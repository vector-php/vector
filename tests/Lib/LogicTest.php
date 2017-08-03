<?php

namespace Vector\Test\Lib;

use PHPUnit\Framework\TestCase;
use Vector\Lib\Logic;

class LogicTest extends TestCase
{
    /**
     * Test that orCombinator works as intended
     */
    public function testOrCombinator()
    {
        $orCombinator = Logic::using('orCombinator');

        $trueOrFalse = $orCombinator([
            function($a){
                return $a === true;
            }, function($a){
                return $a === false;
            }
        ]);

        $this->assertTrue($trueOrFalse(true));
        $this->assertTrue($trueOrFalse(false));
    }

    /**
     * Test that andCombinator works as intended
     */
    public function testAndCombinator()
    {
        $andCombinator = Logic::using('andCombinator');

        $greaterThan0AndLessThan5 = $andCombinator([
            function($a){
                return $a > 0;
            }, function($a){
                return $a < 5;
            }
        ]);

        $this->assertTrue($greaterThan0AndLessThan5(4));
        $this->assertFalse($greaterThan0AndLessThan5(7));
    }

    /**
     * Test that notEq works as intended
     */
    public function testNotEq()
    {
        $notEq = Logic::using('notEq');

        $this->assertTrue($notEq(1, 2));
    }

    /**
     * Test that notEqStrict works as intended
     */
    public function testNotEqStrict()
    {
        $notEqStrict = Logic::using('notEqStrict');

        $this->assertTrue($notEqStrict(1, '1'));
    }

    /**
     * Test that not works as intended
     */
    public function testNot()
    {
        $this->assertEquals(Logic::logicalNot(false), true);
    }

    /**
     * Test that gt works as intended
     */
    public function testGt()
    {
        $this->assertEquals(Logic::gt(1, 2), true);
    }

    /**
     * Test that gt works as intended
     */
    public function testGte()
    {
        $this->assertEquals(Logic::gte(2, 2), true);
    }

    /**
     * Test that lt works as intended
     */
    public function testLt()
    {
        $this->assertEquals(Logic::lt(2, 1), true);
    }

    /**
     * Test that lte works as intended
     */
    public function testLte()
    {
        $this->assertEquals(Logic::lte(2, 2), true);
    }

    /**
     * Test that eq works as intended
     */
    public function testEq()
    {
        $this->assertEquals(Logic::eq(2, '2'), true);
    }

    /**
     * Test that eqStrict works as intended
     */
    public function testEqStrict()
    {
        $this->assertEquals(Logic::eqStrict(2, '2'), false);
    }
}
