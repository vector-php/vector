<?php

namespace Vector\Test\Control;

use Vector\Control\Pattern;
use Vector\Data\Just;
use Vector\Data\Maybe;
use Vector\Data\Nothing;
use Vector\Lib\Lambda;

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
        $match = Pattern::match([
            function (int $a) {
                 return Lambda::always(1);
            },
            function (int $a, int $b) {
                return Lambda::always(2);
            },
        ]);

        $this->assertEquals(2, $match(2, 2));
        $this->assertEquals(1, $match(1));
    }

    public function testThatItMatchesOnType()
    {
        $match = Pattern::match([
            function (string $value) {
                return Lambda::always(1);
            },
            function (int $value) {
                return Lambda::always(2);
            },
        ]);

        $this->assertEquals(1, $match('hello'));
        $this->assertEquals(2, $match(1));
    }

    public function testThatCanExtractJust()
    {
        $match = Pattern::match([
            function ($x) {
                return function () {
                    return Lambda::always('nothing');
                };
            },
            function (Just $value) {
                return function ($extracted) {
                    return $extracted + 1;
                };
            },
        ]);

        $this->assertEquals(2, $match(Maybe::just(1)));
    }

    public function testThatCanMatchOnNothing()
    {
        $match = Pattern::match([
            function (Just $value) {
                return Lambda::always('just');
            },
            function (Nothing $_) {
                return Lambda::always('nothing');
            },
        ]);

        $this->assertEquals('nothing', $match(Maybe::nothing()));
    }

    public function testThatCanMatchUsingEmptyParams()
    {
        $match = Pattern::match([
            function () {
                return Lambda::always('always');
            }
        ]);

        $this->assertEquals('always', $match('w/e'));
    }

    public function testThatCanMatchExplicitValues()
    {
        $match = Pattern::match([
            [[1, 2, 3], function () {
                return Lambda::always('test');
            }]
        ]);

        $this->assertEquals('test', $match(1, 2, 3));
    }

    /**
     * @expectedException \Vector\Core\Exception\IncompletePatternMatchException
     */
    public function testThatThrowsOnNoMatchingPattern()
    {
        $match = Pattern::match([
            function (string $value) {
                return $value . 'asdf';
            },
        ]);

        $this->assertEquals(2, $match(1));
    }
}
