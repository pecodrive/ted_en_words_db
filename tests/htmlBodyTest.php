<?php
require_once('classes.php');

class HtmlBodyTest extends PHPUnit_Framework_TestCase
{
    protected $htmlBody;
    protected $data;
    protected function setUP()
    {
        $this->data = new Data();
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

