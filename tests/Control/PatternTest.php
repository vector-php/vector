<?php

namespace Vector\Test\Control;

use Vector\Control\Pattern;
use Vector\Control\Type;

/**
 * Class PatternTest
 * @package Vector\Test\Control
 */
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

    public function testThatItMatchesOnType()
    {
        $f = function ($a) {
            return Pattern::match([
                [
                    Type::string(),
                    function() {
                        return 1;
                    }
                ],
                [
                    Type::int(),
                    function() {
                        return 2;
                    }
                ]
            ])(...func_get_args());
        };

        $this->assertEquals(1, $f('hello'));
        $this->assertEquals(2, $f(1));
    }
}
