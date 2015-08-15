<?php
require_once('classes.php');

class CompileClassTest extends PHPUnit_Framework_TestCase
{
    protected $compileClass;
    protected $getDomFormXpathDom;
    protected $getDom;
    protected $htmlBody;
    protected $data;
    protected function setUP()
    {
        $this->data = 
            new Data();
        $this->htmlBody = 
            new HtmlBody
            (
                $this->data->url
            );
        $this->getDom = 
            new GetDom
            (
                $this->htmlBody->html
            );
        $this->getDomFromXpathDom = 
            new GetDomFromXpathDom
            (
                $this->getDom->xPathObj, 
                $this->data->query
            );
        $this->compileClass = 
            new CompileClass
            (
                $this->data->url, 
                $this->data->query
            );
    }
    public function testCompileClassConstruct()
    {
        $this-> assertNotEmpty
            ($this->compileClass);
        $this-> assertInternalType
            ('object', $this->compileClass);
    }
}
