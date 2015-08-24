<?php


/**
 * 指定したurlのhtmlを返す
 *
 * @param string $url
 * @return string $html 
 */
class HtmlBody
{
    private $html;
    public function __construct($url)
    {
        $this->html = file_get_contents($url);
    }
    public function __get($name)
    {
        return $this->$name;
    }
}

/**
 * htmlからxpathオブジェクトを得る 
 * 
 * @param string $html
 * @return object $xpath
 */
class getDom
{
    private $xPathObj;
    public function __construct($html)
    {
        $domDoc = new DOMDocument();
        @$domDoc->loadHTML($html);
        $this->xPathObj = new DOMXpath($domDoc);
    }
    public function __get($url)
    {
        return $this->xPathObj;
    }
}
/**
 * Htmlbody用のクエリを渡す
 *
 * @param string $url
 */
class FeedUrlUseByHtmlBody
{
    private $url;
    public function __construct($url)
    {
        $this->url = $url;
    }
    public function __get($name)
    {
        return $this->$name;
    }
}


/**
 * xpath用のクエリを渡す
 *
 * @param string $query
 */
class FeedQueryUseByXpath
{
    private $query;
    public function __construct($query)
    {
        $this->query = $query;
    }
    public function __get($name)
    {
        return $this->$name;
    }
}


/**
 * xpathオブジェクトから目的のDomを得る 
 * 
 * @param object $xPathObj 
 * @return object $purposeDom
 */
class GetDomFromXpathDom
{
    private $purposeDom;
    public function __construct($xPathObj, $query)
    {
        $this->purposeDom = $xPathObj->query($query);
         
    }
    public function __get($name)
    {
        return $this->$name;
    }
}
/**
 * 処理をまとめる
 * 
 * @param string $url
 * @param string $query 
 * 
 */
class CompileClass
{
    private $url;
    private $query;
    private $htmlBodyObj;
    private $xPathObj;
    private $dom;
    public function __construct($url,$query)
    {
        $this->url           = $url;
        $this->query         = $query;
        $this->htmlBodyObj   = new Htmlbody($this->url);
        $this->xPathObj      = new GetDom($this->htmlBodyObj->html);
        $this->dom           = new GetDomFromXpathDom($this->xPathObj->xPathObj, $this->query);
    }
    public function __get($name)
    {
        return $this->$name;
    }
        
} 
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
 * データベースに英和辞典を突っ込む
 * 
 */
class InsertDictionary
{
    private $db;

    /**
     * 偶数なの？ 
     *
     * @param integer $number 
     * @return bool
     */
    private function inspectEven($number)
    {
        $mod = $number % 2;
        if($mod === 0){
            return true;
        }elseif($mod !== 0){
            return false;
        }
    }
    /**
     * データベースに突っ込む役目
     */
    public function __construct()
    {
        $this->db = new ClassOperatingDB();
        $sqlpre = 
        $this->db->getDbhandle()->prepare
        (
           " 
            insert ignore into
            transwords(id,enword,transword) 
            values(:id, :enword, :transword)
           " 
        );
        $sqlpre->bindParam(':id',$id);
        $sqlpre->bindParam(':enword',$enword);
        $sqlpre->bindParam(':transword',$transword);

        $handle = fopen("gene-utf8.txt", "r");
        if ($handle){
            while (($buffer = fgets($handle)) !== false) {
                static $i = 1;
                static $j = 0;
                if ($this->inspectEven($i)) {
                    $transword = str_replace
                        (
                            array("\r\n", "\r", "\n"),
                            '',
                            $buffer
                        ); 
                    $sqlpre->execute(); 
                    $j++;
                    echo "{$j}行目インサート<br>";
                }else{
                    $enword = str_replace
                        (
                            array("\r\n", "\r", "\n"),
                            '',
                            $buffer
                        ); 
                }
                $i++;
            }
            fclose($handle);
            echo "インサート終了　行数".$j."行";
        }
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


