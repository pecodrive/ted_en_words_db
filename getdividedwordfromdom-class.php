<?php

/**
* Domから分割された単語を得る
*
* @param object $purposeDom 
* @return array $dividedWordArray 
*/
class GetDividedWordFromDom implements GetValueInterface
{
    private $dom;
    private $value;
    public function __construct($url, $query)
    {
        $this->dom = new CompileClass($url, $query);
        $dividedWordArray = array();
        foreach ($this->dom->dom->purposeDom as $item) {
            $dividedWordArray = array_merge
                (
                    $dividedWordArray,
                    $this->arrayRebuilding($item)
               );
        }
        $this->value = $dividedWordArray;
    }
    /**
     * 空や不要な要素を配列から削除する
     */
    public function arrayRebuilding($words)
    {
        $wordsArray = preg_split
        (
            "/[\s+.,\"]/", 
            $words->nodeValue
        );
        return $this->unnecessaryElements($wordsArray);
    }
    /**
     * 空白削除
     */
    public function unnecessaryElements($array)
   {
        $unsetwords = array
            (
                "--",
                "(Applause)",
                "(Laughter)"
            );
        $arrayElimi = $array;
        $arrayElimi2 = $this->arraySerchAndUnset
            (
                $arrayElimi, $unsetwords
            );
        $arrayElimi3 = array_filter($arrayElimi2, "strlen");
        $arrayElimi4 = array_values($arrayElimi3);
        return $arrayElimi4;
    }
    /**
     * いらない要素を総検索して消す
     */
    public function arraySerchAndUnset($arrayElimi, $unsetWords)
    {
        $arrayElimiCount = count($arrayElimi);
        $unsetWordsCount = count($unsetWords);
        for ($i=0; $i < $unsetWordsCount; $i++) {
            for ($j=0; $j < $arrayElimiCount; $j++) {
                if($arrayElimi[$j] === $unsetWords[$i]){
                    $arrayElimi[$j] = "";
                }
            }
        }
        return $arrayElimi;
    }
    public function getValue()
    {
        return $this->value;
    }
    public function getValueByNumber($number)
    {
        return $this->value[$number];
    }
}


