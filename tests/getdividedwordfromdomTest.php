<?php
class GetDividedWordFromDomTest extends PHPUnit_Framework_TestCase
{
    protected $getDividedWordFromDom;
    protected $data;
    protected function setUP()
    {
        $this->data = new Data();
        $this->getDividedWordFromDom = 
            new GetDividedWordFromDom
            (
                $this->data->url,
                $this->data->query 
            );
    }
    public function testGetDividedWordFromDomConstruct()
    {
        $this-> assertNotEmpty
            (
                $this->getDividedWordFromDom,
                $message='htmlBody is Empty'
            );
        $this-> assertInternalType
            (
                'object',
                $this->getDividedWordFromDom
            );
    }
}
