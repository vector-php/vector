<?php

namespace Vector\Test\Lib;

use Vector\Lib\Math;

class MathTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test that you can add two numbers together
     */
    public function testAdd()
    {
        $add = Math::using('add');

        $this->assertEquals(5, $add(2, 3));
    }

    /**
     * Test that you can sum a list of numbers
     */
    public function testSum()
    {
        $sum = Math::using('sum');

        $this->assertEquals(9, $sum([2, 3, 4]));
    }

    /**
     * Test that you can negate a number
     */
    public function testNegate()
    {
        $negate = Math::using('negate');

        $this->assertEquals(-1, $negate(1));
    }

    /**
     * Test that you can subtract two numbers. The second argument is subtracted
     * from the first argument.
     */
    public function testSubtract()
    {
        $subtract = Math::using('subtract');

        $this->assertEquals(5, $subtract(5, 10));
    }

    /**
     * Test that multiply works properly
     */
    public function testMultiply()
    {
        $multiply = Math::using('multiply');

        $this->assertEquals(10, $multiply(5, 2));
    }

    /**
     * Test that product works properly
     */
    public function testProduct()
    {
        $product = Math::using('product');

        $this->assertEquals(6, $product([1, 2, 3]));
    }

    /**
     * Test that two numbers are divided. The first argument is the divisor, e.g.
     * the denominator.
     */
    public function testDivide()
    {
        $divide = Math::using('divide');

        $this->assertEquals(4, $divide(2, 8));
    }

    /**
     * Test the modulus function. The first argument is the modulus. e.g. a, b = b % a
     */
    public function testMod()
    {
        $mod = Math::using('mod');

        $this->assertEquals(3, $mod(5, 8));
    }

    /**
     * Test the power function. The first argument is the power base. e.g. a, b = b ^ a
     */
    public function testPow()
    {
        $pow = Math::using('pow');

        $this->assertEquals(8, $pow(3, 2));
    }
}
