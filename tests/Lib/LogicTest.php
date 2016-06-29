<?php

namespace Vector\Test\Lib;

use Vector\Lib\Logic;

class LogicTest extends \PHPUnit_Framework_TestCase
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
}
