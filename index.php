<?php
/**
 * executerのインターフェース
 */
interface ExecuterInterface
{
    public function execute($varNameArray, $sqlpre, $value, $placeHolderArray);
}
interface GetValueInterface
{
    public function getValue();
}
/**
 * executerの原型
 */
Abstract class Executer implements ExecuterInterface
{
    public function execute($varNameArray, $sqlpre,  $value, $placeHolderArray)
    {
        foreach ($varNameArray as $item) {
           static $i = 0;
           $$varNameArray[$i] =
               WordRepair::wordFirstUpperCaseRepair($value[$i]);
           $i++;
        }
        $sqlpre->execute(); 
        return $sqlpre->fetchAll();
    }
}

require_once(dirname(__FILE__).'/class/classes.php');

$query = 'body//div[@class="talk-article__body talk-transcript__body"]//span';
$url = 'http://www.ted.com/talks/shawn_achor_the_happy_secret_to_better_work/transcript?language=en';

$wordArray = new GetDividedWordFromDom($url, $query);
$op = new DbGenericOperation(new SelectWords(), $wordArray);
    $op->runSql
    (
        "select transword from transwords where enword=:word"
    );
var_dump($op);
//var_dump($op);
