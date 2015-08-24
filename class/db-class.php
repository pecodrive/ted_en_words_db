<?php

class ClassOperatingDB
{
   private $dbhandle;
   function __construct()
    {
        try{
        $dbhandle = 
            new PDO
            (
                'mysql:dbname=tedword;host=localhost;charset-utf8',
                'tedworddbuser',
                'hjk26dfg'
            );

        }catch(PDOException $e)
        {
            die('Error->'.$e->getMessage());
        }
        $this->dbhandle = $dbhandle;
    }
   function getDbhandle()
   {
       return $this->dbhandle;
   }
}
/**
 * sqlクエリの発行
 */
class SelctSql
{
    static function selectTranswordByEnWord()
    {
        $sql = 
            "select transword".
            "from transwords". 
            "where word= :word";
        return $sql;
    }

}
