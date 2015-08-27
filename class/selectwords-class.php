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
            for($j=0; $j < $countVarNameArray; $j++) {
                $varName = (string)$varNameArray[$j];
                $sqlpre->bindParam
                    (
                        $placeHolderArray[$i],
                        $varName
                    );
               $$varNameArray[$j] = $value[$i];
            }
            $sqlpre->execute();
            $result[] = $this->examineResult($sqlpre->fetchAll());
        }
        return $result;
    }
    public function examineResult($result)
    {
        if(empty($result)){
            echo "NO result";
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
