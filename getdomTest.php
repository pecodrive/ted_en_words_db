<?php
require_once('classes.php');

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
            ($this->getDom, $message='htmlBody is Empty'); 
        $this-> assertInternalType
            ('object', $this->getDom);
    }
}
