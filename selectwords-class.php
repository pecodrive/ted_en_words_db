<?php

/**
 * 単語翻訳
 *
 *
 */
class SelectWords extends Executer 
{
    public function execute($varNameArray, $sqlpre, $value, $placeHolderArray)
    {
        //todo データバインドの方法を変える以下がんばれ
        $countValueArray = count($value);
        $countVarNameArray = count($varNameArray);
        for ($i=0; $i < $countValueArray; $i++) {
        //for ($i=0; $i < 10; $i++) {
            for($j=0; $j < $countVarNameArray; $j++) {
                $$varNameArray[$j] =
                    WordRepair::wordFirstUpperCaseRepair($value[$i]);
                $sqlpre->bindValue
                    (
                        $placeHolderArray[$j],
                        $$varNameArray[$j]
                    );
            }
            $sqlpre->execute();
            $result[$i] = $this->examineResult($sqlpre->fetchAll());
            $result[$i][0]["enword"] = $value[$i];
        }
        return $result;
    }
    public function examineResult($result)
    {
        if(empty($result)){
        return array(array("transword"=>"NOresult",0=>"NOresult"));
        }
        return $result;
    }
}
class WordRepair {
    static function wordFirstUpperCaseRepair ($word)
    {
        $pattern = '/^I|[A-Z]{2,}/';
        $matchreturn = preg_match($pattern, $word, $match); 
        if (
            $matchreturn === 0 ||
            $matchreturn === false
        ){
            $repairWord = strtolower($word);
        }else{
            $repairWord = $word;
        }
        return $repairWord;
    }
}
