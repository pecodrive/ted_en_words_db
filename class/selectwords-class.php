<?php

/**
 * 単語翻訳
 *
 *
 */
class SelectWords
{
    private $db;
    private $result;
    public function __construct()
    {
        $this->db = new ClassOperatingDB(); 
    }
    public function selctWordFunc($sql, $word)
    {
        $repairWord = ($word);
        $sqlpre = $this->db->getDbhandle()->prepare
            (
                $sql
            );
        $sqlpre->bindParam( ':word', $word); 
        $sqlpre->execute();
        $this->result = $sqlpre->fetchAll();
    }
    public function getResult()
    {
            return $this->result[0]["transword"];
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
