<?php
require_once('classes.php');

class GetDomTest extends PHPUnit_Framework_TestCase
{
    protected $htmlBody;
    protected $data;
    protected $getDom;
    protected function setUP()
    {
        $this->data = new Data;
        $this->htmlBody = new HtmlBody($this->data->url);
        $this->getDom = new GetDom($this->htmlBody->html);
    }
    public function testGetDomConstruct()
    {
        $this-> assertNotEmpty
            ($this->getDom, $message='htmlBody is Empty'); 
        $this-> assertInternalType
            ('object', $this->getDom);
    }
}
