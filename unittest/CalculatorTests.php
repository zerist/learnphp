<?php
require "Calculator.php";

require 'vendor/autoload.php';

use \PHPUnit\Framework\TestCase;

class CalculatorTests extends TestCase{
    private $test;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->test = new Calculator();
    }

    protected function tearDown(): void
    {
        parent::tearDown(); // TODO: Change the autogenerated stub
        $this->test = NULL;
    }

    public function testAdd(){
        $res = $this->test->add(1, 3);
        $this->assertEquals(4, $res);
    }
}
