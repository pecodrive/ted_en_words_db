<?php
require_once('classes.php');

class GetDomFromXpathDomTest extends PHPUnit_Framework_TestCase
{
    protected $getDomFormXpathDom;
    protected $getDom;
    protected $htmlBody;
    protected $data;
    protected function setUP()
    {
        $this->data = new Data();
        $this->htmlBody = new HtmlBody($this->data->url);
        $this->getDom = new GetDom($this->htmlBody->html);
        $this->getDomFromXpathDom = new GetDomFromXpathDom($this->getDom->xPathObj, $this->data->query);
    }
    public function testGetDomFromXpathDomConstruct()
    {
        $this-> assertNotEmpty
            ($this->getDomFromXpathDom, $message='htmlBody is Empty'); 
        $this-> assertInternalType
            ('object', $this->getDomFromXpathDom);
    }
}
