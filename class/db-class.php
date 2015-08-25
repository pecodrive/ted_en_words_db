<?php
/**
 * DBの初期化
 */
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
/**
 * executerのインターフェース
 */
interface InsertExecute
{
    public function executer();
}
/**
 * DBへの汎用操作クラス
 */
class DbGenericOperation
{
    private $varNameArray;
    private $placeHolderArray;
    private $db;
    private $sqlpre;
    /**
     * クエリのプレースフォルダを解析する
     */
    public function queryInterpretation($query)
    {
        $pattern = '/:[a-zA-z]+/';
        preg_match_all($pattern, $query, $match);
        return $match;
    }
    /**
     * プレースホルダからデータバインド用の変数名を作る
     */
    public function varNameForPlaceHolder($placeHolderArray)
    {
        $varName = array();
        foreach ($placeHolderArray as $item){
            array_push($varName, preg_replace(":", "", $item));
        }
        return $varName;
    }
    /**
     * クエリとexecuterを与えてインサートを実行する
     */
    public function __construct($query, InsertExecute $executer)
    {
        $this->placeHoderArray = $this->queryInterpretation($query);
        $this->varNameArray = 
            $this->varNameForPlaceHolder($this->placeHoderArray);
        $this->db = new ClassOperatingDB();
        $this->sqlpre = $this->db->getDbhandle()->prepare($query);
        foreach ($this->varNameArray as $item) {
            static $i = 0;
            $this->sqlpre->bindParam($item,$$this->varNameArray[$i]);
            $i++;
         }
        $executer->executer($this->varNameArray, $this->sqlpre);
    }
}
/**
 * executerの原型
 */
class InsertExecuter implements InsertExecute
{
    public function executer($varNameArray, $sqlpre)
    {
        foreach ($varNameArray as $item) {
           static $i = 0;
           $$varNameArray[$i] = $value;
           $i++;
        }
        $sqlpre->execute(); 
    }
}


