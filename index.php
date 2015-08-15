<?php

//phpinfo();
//echo __FILE__;
//$db = new SQLite3("sqlitedb.db");
//$db->exec('CREATE TABLE words(id integer PRIMARY KEY AUTOINCREMENT, words text, trans text, frequency interger) ');

$url = 'http://www.ted.com/talks/shawn_achor_the_happy_secret_to_better_work/transcript?language=en';
$html = file_get_contents($url);
$doc = new DOMDocument();
@$doc->loadHTML($html);
$xpath = new DOMXpath($doc);

$baz_list = $xpath->query('body//div[@class="talk-article__body talk-transcript__body"]//span');
//$value = $baz_list;

foreach ($baz_list as $item) {
    $text[] = $item->nodeValue;
}

var_dump($text);
