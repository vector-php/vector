<?php

namespace Vector\Test\Control;

use PHPUnit\Framework\TestCase;
use Vector\Control\Pattern;
use Vector\Control\Type;
use Vector\Core\Exception\IncompletePatternMatchException;

/**
 * Class PatternTest
 * @package Vector\Test\Control
 */
class PatternTest extends TestCase
{
    public function testThatItMakesPatterns()
    {
        $this->assertEquals(Pattern::make(Pattern::_), Pattern::any());
        $this->assertEquals(Pattern::make('asdf'), Pattern::string('asdf'));
        $this->assertEquals(Pattern::make(5), Pattern::string(5));
        $this->assertEquals(Pattern::make(3.14), Pattern::string(3.14));
    }

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
            /** @noinspection PhpParamsInspection */
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

    public function testThatItRequiresCompletePatterns()
    {
        $f = function($a) {
            return Pattern::match([
                [ 0, function() { return 'a'; } ],
                [ 1, function() { return 'b'; } ],
            ])(...func_get_args());
        };

        $this->expectException(IncompletePatternMatchException::class);
        $f(5);
    }

    public function testThatNumbersArePatternMatched()
    {
        $this->assertEquals(Pattern::number(3, 3), true);
        $this->assertEquals(Pattern::number(3, 3.0), true);
        $this->assertEquals(Pattern::number(3, 'asdf'), false);
    }

    public function testThatStringsArePatternMatched()
    {
        $this->assertEquals(Pattern::string('foo', 'foo'), true);
        $this->assertEquals(Pattern::string('foo', 'bar'), false);
    }

    public function testThatAnyIsPatternMatched()
    {
        $this->assertEquals(Pattern::any(null, 'foo'), true);
        $this->assertEquals(Pattern::any(null, 1), true);
        $this->assertEquals(Pattern::any(null, [1, 2, 3]), true);
    }
}
