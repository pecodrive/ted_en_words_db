<?php
require_once('classes.php');
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
class HtmlBodyTest extends PHPUnit_Framework_TestCase
{
    protected $htmlBody;
    protected $data;
    protected function setUP()
    {
        $this->data = new Data;
        $this->htmlBody = new HtmlBody($this->data->url);
    }
    public function testHtmlBodyConstruct()
    {
        $this-> assertNotEmpty
            ($this->htmlBody, $message='htmlBody is Empty');
        $this-> assertInternalType
            ('object', $this->htmlBody);
    }
}

class GetDomTest extends PHPUnit_Framework_TestCase
{
    protected $htmlBody;
    protected $getDom;
    protected function setUP()
    {
        $this->htmlBody = new HtmlBody($this->url);
        $this->getDom = new GetDom($this->htmlBody->html);
    }
    public function testGetDomConstruct()
    {
        $this-> assertNotEmpty
            ($this->htmlBody, $message='htmlBody is Empty'); 
        $this-> assertInternalType
            ('object', $this->getDom);
    }
}
