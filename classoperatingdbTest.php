<?php
require_once('classes.php');

class ClassOperatingDBTest extends PHPUnit_Framework_TestCase
{
    protected $classOpetathingDB;
    protected function setUP()
    {
        $this->classOpetathingDB = new ClassOperatingDB();
    }
    public function testClassOpetatingDBCostruct()
    {
        $this-> assertNotEmpty($this->classOpetathingDB);
        $this-> assertInternalType($this->classOpetathingDB); 
    }
}
