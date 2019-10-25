<?php

namespace Vector\Test\Lib;

use PHPUnit\Framework\TestCase;
use Vector\Lib\Lambda;
use Vector\Lib\Math;
use Vector\Test\Lib\Stub\TestFunctions;

class LambdaTest extends TestCase
{
    /** @test */
    function compose_order_is_back_to_front()
    {
        $compose = Lambda::using('compose');
        list($timesTwo, $plusTwo) = TestFunctions::using('timesTwo', 'plusTwo');

        $composeSingle = $compose($plusTwo);
        $composeDouble = $compose($timesTwo, $plusTwo);

        $this->assertInstanceOf('\\Closure', $composeSingle);
        $this->assertInstanceOf('\\Closure', $composeDouble);

        $this->assertEquals($composeSingle(0), 2);
        $this->assertEquals($composeDouble(2), 8);
    }

    /** @test */
    function compose_null_value_handling()
    {
        $compose = Lambda::using('compose');
        [$returnsTrue, $invertsBool, $expectsNotNull] = TestFunctions::using(
            'returnsTrue',
            'invertsBool',
            'expectsNotNull'
        );

        $shouldBeFalse = $compose($invertsBool, $returnsTrue);
        $shouldBeTrue = $compose($invertsBool, $invertsBool, $returnsTrue);

        $this->assertEquals(false, $shouldBeFalse(null));
        $this->assertEquals(true, $shouldBeTrue(null));

        $shouldBeNull = $compose($invertsBool, $expectsNotNull);

        $this->assertEquals(false, $shouldBeNull('foo'));
        $this->assertEquals(true, $shouldBeNull(null));
    }

    /** @test */
    function pipe_order_is_front_to_back()
    {
        $pipe = Lambda::using('pipe');
        [$timesTwo, $plusTwo] = TestFunctions::using('timesTwo', 'plusTwo');

        $pipeSingle = $pipe($plusTwo);
        $pipeDouble = $pipe($timesTwo, $plusTwo);

        $this->assertInstanceOf('\\Closure', $pipeSingle);
        $this->assertInstanceOf('\\Closure', $pipeDouble);

        $this->assertEquals($pipeSingle(0), 2);
        $this->assertEquals($pipeDouble(2), 6);
    }

    /** @test */
    function k()
    {
        $k = Lambda::using('k');

        $constant = $k(2);

        $this->assertEquals(2, $constant(7));
        $this->assertEquals(2, $constant(1, 2, 3));
    }

    /** @test */
    function id()
    {
        $id = Lambda::using('id');

        $this->assertEquals(4, $id(4));
        $this->assertEquals('foo', $id('foo'));
    }

    /** @test */
    function flip()
    {
        $flip = Lambda::using('flip');

        $subtract = function ($a, $b) {
            return $b - $a;
        };

        $flippedSubtract = $flip($subtract);

        $this->assertEquals(4, $subtract(2, 6)); // 6 - 2
        $this->assertEquals(-4, $flippedSubtract(2, 6)); // 2 - 6
    }

    /** @test */
    function dot()
    {
        $add2ThenAdd1 = Lambda::dot(Math::add(1), Math::add(2));

        $this->assertEquals(3, $add2ThenAdd1(0));
    }

    /** @test */
    function apply()
    {
        $this->assertEquals(2, Lambda::apply(Math::add(1), 1));
    }
}
