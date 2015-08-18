<?php

/**
 * test
 */
class Tests
{
    private $name; 
    public function __construct($name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }
}
class TestsCh extends Tests
{
}
$class = new TestsCh("minoru");
var_dump($class->getName());
