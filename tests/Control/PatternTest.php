<?php

namespace Vector\Test\Control;

use Vector\Control\Pattern;
use Vector\Data\Either\Either;
use Vector\Data\Either\Left;
use Vector\Data\Either\Right;
use Vector\Data\Maybe\Just;
use Vector\Data\Maybe\Maybe;
use Vector\Data\Maybe\Nothing;
use Vector\Lib\Lambda;
use Vector\Test\Control\Stub\TestInts;
use Vector\Test\Control\Stub\TestIntsAndString;
use Vector\Test\Control\Stub\TestMultipleTypeConstructor;
use Vector\Test\Control\Stub\TestObject;

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

    public function testThatCanExtractMultipleArgTypeConstructor()
    {
        $match = Pattern::match([
            function (TestIntsAndString $intsAndString) {
                return function (int $a, int $b, string $str) {
                    return Lambda::always('nope');
                };
            },
            function (TestInts $ints) {
                return function (int $a, int $b, int $c) {
                    return $a + $b + $c;
                };
            },
        ]);

        $this->assertEquals(6, $match(TestMultipleTypeConstructor::ints(1, 2, 3)));
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

    public function testThatCanMatchOnEitherRight()
    {
        $match = Pattern::match([
            function (Right $value) {
                return Lambda::id();
            },
            function (Left $error) {
                return Lambda::id();
            },
        ]);

        $this->assertEquals(1, $match(Either::right(1)));
    }

    public function testThatCanMatchOnEitherLeft()
    {
        $match = Pattern::match([
            function (Right $value) {
                return Lambda::id();
            },
            function (Left $error) {
                return Lambda::id();
            },
        ]);

        $this->assertEquals('something broke!', $match(Either::left('something broke!')));
    }

    public function testThatCanMatchOnEitherRightGeneratedFromMaybe()
    {
        $match = Pattern::match([
            function (Left $error) {
                return function (string $error) {
                    return $error;
                };
            },
            function (Right $value) {
                return function (int $value) {
                    return $value;
                };
            },
        ]);

        $this->assertEquals(5, $match(Either::fromMaybe('error', Maybe::just(5))));
    }

    public function testThatCanMatchOnEitherLeftGeneratedFromMaybe()
    {
        $match = Pattern::match([
            function (Left $error) {
                return Lambda::id();
            },
            function (Right $value) {
                return Lambda::always('works');
            },
        ]);

        $this->assertEquals('error', $match(Either::fromMaybe('error', Maybe::nothing())));
    }

    public function testThatCanMatchUsingEmptyParams()
    {
        $match = Pattern::match([
            function () {
                return Lambda::always('always');
            },
        ]);

        $this->assertEquals('always', $match('w/e'));
    }

    public function testThatCanMatchOnCustomObject()
    {
        $match = Pattern::match([
            function (TestObject $object) {
                return $object->getValue();
            },
        ]);

        $this->assertEquals('works', $match(new TestObject()));
    }

    public function testThatCanMatchExplicitValues()
    {
        $match = Pattern::match([
            [[1, 2, 3], function () {
                return Lambda::always('test');
            }],
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
