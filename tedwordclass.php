<?php


$query = 'body//div[@class="talk-article__body talk-transcript__body"]//span';
$url = 'http://www.ted.com/talks/shawn_achor_the_happy_secret_to_better_work/transcript?language=en';
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
            $dividedWordArray = array_merge(
                $dividedWordArray,
                preg_split("/[\s+.,]/", $item->nodeValue)
            );
        }
        $this->words = $dividedWordArray;
    }
    public function getWords()
    {
        return $this->words;
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
class insertDictionary
{
    /**
     * 偶数なの？ 
     *
     * @param integer $number 
     * @return bool
     */
    static function inspectEven($number)
    {
        if($number === 0){
            return false;
            die();
        }
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
    static function insertFunction()
    {
        $db = new ClassOperatingDB();
        $sqlpre = 
        $db->getDbhandle()->prepare
        (
            '
            insert into
            transwords(id, enword, transword) 
            values(:id, :enword, :transword)
            '
        );
        $sqlpre->bindParam(':id',$id);
        $sqlpre->bindParam(':enword',$enword);
        $sqlpre->bindParam(':transword',$transword);

        $i = 1;
        $handle = fopen("gene-utf8.txt", "r");
        if ($handle){
            while (($buffer = fgets($handle)) !== false) {
                if (inspectEven($i)) {
                    $transword = $buffer;
                    $sqlpre->execute(); 
                }else{
                    $enword = $buffer;
                }
                $i++;
            }
            fclose($handle);
        }
    }
}





