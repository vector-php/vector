<?php

namespace Vector\Test\Lib;

use PHPUnit\Framework\TestCase;
use Vector\Lib\Logic;

class LogicTest extends TestCase
{
    /** @test */
    function or_combinator()
    {
        $orCombinator = Logic::using('orCombinator');

        $trueOrFalse = $orCombinator([
            function ($a) {
                return $a === true;
            }, function ($a) {
                return $a === false;
            },
        ]);

        $this->assertTrue($trueOrFalse(true));
        $this->assertTrue($trueOrFalse(false));
    }

    /** @test */
    function and_combinator()
    {
        $andCombinator = Logic::using('andCombinator');

        $greaterThan0AndLessThan5 = $andCombinator([
            function ($a) {
                return $a > 0;
            }, function ($a) {
                return $a < 5;
            },
        ]);

        $this->assertTrue($greaterThan0AndLessThan5(4));
        $this->assertFalse($greaterThan0AndLessThan5(7));
    }

    /** @test */
    function not_eq()
    {
        $notEq = Logic::using('notEq');

        $this->assertTrue($notEq(1, 2));
    }

    /** @test */
    function not_eq_strict()
    {
        $notEqStrict = Logic::using('notEqStrict');

        $this->assertTrue($notEqStrict(1, '1'));
    }

    /** @test */
    function not()
    {
        $this->assertEquals(Logic::logicalNot(false), true);
    }

    /** @test */
    function gt()
    {
        $this->assertEquals(Logic::gt(1, 2), true);
    }

    /** @test */
    function gte()
    {
        $this->assertEquals(Logic::gte(2, 2), true);
    }

    /** @test */
    function lt()
    {
        $this->assertEquals(Logic::lt(2, 1), true);
    }

    /** @test */
    function lte()
    {
        $this->assertEquals(Logic::lte(2, 2), true);
    }

    /** @test */
    function eq()
    {
        $this->assertEquals(Logic::eq(2, '2'), true);
    }

    /** @test */
    function eq_strict()
    {
        $this->assertEquals(Logic::eqStrict(2, '2'), false);
    }
}
