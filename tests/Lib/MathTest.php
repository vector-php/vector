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
        $this->assertEquals(9, Math::sum([2, 3, 4]));
    }

    /** @test */
    function negate()
    {
        $this->assertEquals(-1, Math::negate(1));
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
        $this->assertEquals(5, Math::subtract(5, 10));
    }

    /** @test */
    function multiply()
    {
        $this->assertEquals(10, Math::multiply(5, 2));
    }

    /** @test */
    function product()
    {
        $this->assertEquals(6, Math::product([1, 2, 3]));
    }

    /** @test */
    function product_of_empty_is_0()
    {
        $this->assertEquals(0, Math::product([]));
    }

    /** @test */
    function divide_first_arg_is_divisor_second_is_denominator()
    {
        $this->assertEquals(4, Math::divide(2, 8));
    }

    /** @test */
    function mod_first_arg_is_the_modulus()
    {
        $this->assertEquals(3, Math::mod(5, 8));
    }

    /** @test */
    function pow_first_arg_is_the_base()
    {
        $this->assertEquals(8, Math::pow(3, 2));
    }

    /** @test */
    function range()
    {
        $this->assertEquals([1, 2, 3, 4, 5], Math::range(1, 1, 5));
    }

    /** @test */
    function range_doesnt_break_on_exceeding_specified_range()
    {
        $this->assertEquals([0], Math::range(5, 0, 0));
    }
}
