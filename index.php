<?php

require_once("tedwordclass.php");

$query = 'body//div[@class="talk-article__body talk-transcript__body"]//span';
$url = 'http://www.ted.com/talks/shawn_achor_the_happy_secret_to_better_work/transcript?language=en';

$wordArray = new GetDividedWordFromDom($url, $query);
$selctobj = new SelectWords();
foreach ($wordArray->getWords() as $item) {
    static $i = 0;
    $selctobj->selctWordFunc
    (
        "select transword from transwords where enword=:word",
        $item
    );
    echo $wordArray->getWordsByNumber($i).
        " : ".$selctobj->getResult()."<br>";
    $i++;
}
//new InsertDictionary();
