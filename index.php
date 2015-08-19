<?php

require_once("tedwordclass.php");

$wordArray = new GetDividedWordFromDom($url, $query);
var_dump($wordArray->getWords());
