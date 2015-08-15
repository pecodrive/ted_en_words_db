<?php

//phpinfo();
//echo __FILE__;
//$db = new SQLite3("sqlitedb.db");
//$db->exec('CREATE TABLE words(id integer PRIMARY KEY AUTOINCREMENT, words text, trans text, frequency interger) ');

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
        foreach ($this->dom->dom as $item) {
            $dividedWordArray = array_merge(
                $dividedWordArray, preg_split("/[\s+.]/", $item->nodeValue));
        }
        $this->words = $dividedWordArray;
    }
    public function getWords()
    {
        return $this->words;
    }
}

$wordArray = new GetDividedWordFromDom($url, $query);
var_dump($wordArray->getWords());
