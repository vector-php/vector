<?php

namespace Vector\Test\Control;

use Vector\Control\Pattern;

class PatternTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the we have an informative error when no arguments are given
     */
    public function testThatItMatchesOnArity()
    {
        $f = function ($a) {
            return Pattern::match([
                [
                    Pattern::any(),
                    function() {
                        return 1;
                    }
                ],
                [
                    Pattern::any(),
                    Pattern::any(),
                    function() {
                        return 2;
                    }
                ]
            ])(...func_get_args());
        };

        $this->assertEquals(2, $f(2, 2));
        $this->assertEquals(1, $f(1));
    }
}
