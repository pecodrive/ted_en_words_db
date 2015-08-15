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
class Htmlbody
{
    public function __construct($url)
    {
        $html = file_get_contents($url);
        return $html;
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
    public function __construct()
    {
        $domDoc = new DOMDocument();
        @$domDoc->loadHTML($html);
        $xPath = new DOMXpath($domDoc);
        return $xPath;
    }
}
/**
 * xpath用のクエリを渡す
 *
 * @param string $query
 */
class FeedQueryUseByXpath
{
    public function __construct($query)
    {
        return $query;
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
    public function __construct($xPathObj)
    {
        $purposeDom = $xPathObj->query($query);
        return $purposeDom;
    }
}

/**
* Domから分割された単語を得る
* 
* @return array 
 */
class GetDividedWordFromDom
{
    public function __construct($purposeDom)
    {
        $dividedWordArray = array();
        foreach ($purposeDom as $item) {
            $dividedWordArray = array_merge(
                $dividedWordArray, preg_split("/[\s+]/", $item->nodeValue));
        }
    }
}
