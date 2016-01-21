<?php

namespace Vector\Algebra\Lib\__tests__;

use Vector\Algebra\Lib\Math;

class MathTest extends \PHPUnit_Framework_TestCase
{
    public function testMultiply()
    {
        $multiply = Math::using('multiply');

        $a = 5;
        $b = 20;

        $this->assertEquals($a * $b, $multiply($a, $b));
    }
}