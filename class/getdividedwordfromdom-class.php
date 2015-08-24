<?php

/**
* Domから分割された単語を得る
*
* @param object $purposeDom 
* @return array $dividedWordArray 
*/
class GetDividedWordFromDom
{
    private $dom;
    private $words;
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
        $this->words = $dividedWordArray;
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
    public function unnecessaryElements($array)
   {
        $unsetwords = array
            (
                "--",
                "(Applause)",
                "(Laughter)"
            );
        $arrayElimi = $array;
        $arrayElimi = array_filter($arrayElimi, "strlen");
        $arrayElimi = $this->arraySerchAndUnset
            (
                $arrayElimi, $unsetwords
            );
        return $arrayElimi;
    }
    public function arraySerchAndUnset($arrayElimi, $unsetWord)
    {
        $arrayElimi = array_values($arrayElimi);
        foreach ($unsetWord as $item) {
            //echo $item;
            $key = true;
            while ($key == true) {
                $key = array_search($item, $arrayElimi);
                if($key){
                    unset($arrayElimi[$key]);
                }
            }
        }
        $arrayElimi = array_values($arrayElimi);
        return $arrayElimi;
    }
    public function getWords()
    {
        return $this->words;
    }
    public function getWordsByNumber($number)
    {
        return $this->words[$number];
    }
}


