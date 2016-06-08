<?php

namespace Vector\Test\Lib;

use Vector\Lib\Logic;

class LogicTest extends \PHPUnit_Framework_TestCase
{
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
