<?php

namespace Vector\Test\Lib;

use PHPUnit\Framework\TestCase;
use Vector\Lib\Math;

class MathTest extends TestCase
{
    /** @test */
    function add()
    {
        $add = Math::add();

        $this->assertEquals(5, $add(2, 3));
    }

    /** @test */
    function sum()
    {
        $sum = Math::using('sum');

        $this->assertEquals(9, $sum([2, 3, 4]));
    }

    /** @test */
    function negate()
    {
        $negate = Math::using('negate');

        $this->assertEquals(-1, $negate(1));
    }

    /** @test */
    function min()
    {
        $this->assertEquals(1, Math::min(1, 5));
    }

    /** @test */
    function max()
    {
        $this->assertEquals(5, Math::max(1, 5));
    }

    function mean()
    {
        $this->assertEquals(2, Math::mean([1, 2, 3]));
    }

    /** @test */
    function subtract_is_first_arg_from_second()
    {
        $subtract = Math::using('subtract');

        $this->assertEquals(5, $subtract(5, 10));
    }

    /** @test */
    function multiply()
    {
        $multiply = Math::using('multiply');

        $this->assertEquals(10, $multiply(5, 2));
    }

    /** @test */
    function product()
    {
        $product = Math::using('product');

        $this->assertEquals(6, $product([1, 2, 3]));
    }

    /** @test */
    function product_of_empty_is_0()
    {
        $product = Math::using('product');

        $this->assertEquals(0, $product([]));
    }

    /** @test */
    function divide_first_arg_is_divisor_second_is_denominator()
    {
        $divide = Math::using('divide');

        $this->assertEquals(4, $divide(2, 8));
    }

    /** @test */
    function mod_first_arg_is_the_modulus()
    {
        $mod = Math::using('mod');

        $this->assertEquals(3, $mod(5, 8));
    }

    /** @test */
    function pow_first_arg_is_the_base()
    {
        $pow = Math::using('pow');

        $this->assertEquals(8, $pow(3, 2));
    }

    /** @test */
    function range()
    {
        $range = Math::using('range');

        $this->assertEquals([1, 2, 3, 4, 5], $range(1, 1, 5));
    }

    /** @test */
    function range_doesnt_break_on_exceeding_specified_range()
    {
        $range = Math::using('range');

        $this->assertEquals([0], $range(5, 0, 0));
    }
}
