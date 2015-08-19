<?php
require_once('tedwordclass.php');
class Data 
{
     private $url = 
        'http://www.ted.com/'.
        'talks/shawn_achor_the_happy_secret_to_better_work/'.
        'transcript?language=en';
     private $query = 
        'body//div'.
        '[@class="talk-article__body talk-transcript__body"]'.
        '//span';
     public function __get($name)
     {
         return $this->$name;
     }
}
