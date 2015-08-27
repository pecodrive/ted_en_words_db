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
 * DBへの汎用操作クラス
 */
class DbGenericOperation
{
    private $varNameArray;
    private $placeHolderArray;
    private $db;
    private $sqlpre;
    private $result;
    private $valueObj;
    private $executer;

    public function __construct(ExecuterInterface $executer,  $valueObj)
    {
        $this->executer = $executer;
        $this->value = $valueObj;
    }
    /**
     * クエリのプレースフォルダを解析する
     */
    public function queryInterpretation($query)
    {
        $pattern = '/:[a-zA-z]+/';
        static $matchArray = array();
        preg_match_all($pattern, $query, $match);
        foreach ($match as $item) {
            $matchArray = $item;
        }
        $this->placeHolderArray = $matchArray;
    }
    /**
     * プレースホルダからデータバインド用の変数名を作る
     */
    public function varNameForPlaceHolder()
    {
        $varName = array();
        $count = count($this->placeHolderArray);
        for ($i=0; $i < $count; $i++) {
            $varName[] = preg_replace
                ("/:/", "", $this->placeHolderArray[$i]);
        }
        $this->varNameArray = $varName;
    }
    /**
     * クエリとexecuterを与えて実行する
     */
    public function runSql($query)
    {
        $this->queryInterpretation($query);
        $this->varNameForPlaceHolder();
        $this->db = new ClassOperatingDB();
        $this->sqlpre = $this->db->getDbhandle()->prepare($query);
        $count = count($this->placeHolderArray);
        //todo 以下の箇所直し中注意
        for ($i=0; $i < $count; $i++) {
            $varName = (string)$this->varNameArray[$i];
            var_dump($this->varNameArray);
            $this->sqlpre->bindValue
                (
                    $this->placeHolderArray[$i],
                    $varName
                );
        }
        $this->sqlpre->debugDumpParams();
        $this->result =
            $this->executer->execute
            (
                $this->varNameArray,
                $this->sqlpre,
                $this->value->getValue(),
                $this->placeHolderArray
            );
    }
}



