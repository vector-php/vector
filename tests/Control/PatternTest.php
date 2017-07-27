<?php

namespace Vector\Test\Control;

use Vector\Control\Pattern;
use Vector\Control\Type;
use Vector\Data\Maybe;
use Vector\Lib\Lambda;
use Vector\Lib\Logic;

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
            [
                Pattern::any(),
                Lambda::always(1)
            ],
            [
                Pattern::any(),
                Pattern::any(),
                Lambda::always(2)
            ]
        ]);

        $this->assertEquals(2, $match(2, 2));
        $this->assertEquals(1, $match(1));
    }

    public function testThatItMatchesOnType()
    {
        $match = Pattern::match([
            [
                Type::string(),
                Lambda::always(1)
            ],
            [
                Type::int(),
                Lambda::always(2)
            ]
        ]);

        $this->assertEquals(1, $match('hello'));
        $this->assertEquals(2, $match(1));
    }

    public function testThatCanExtractJust()
    {
        $match = Pattern::match([
            [Pattern::just(), function ($value) {
                return $value + 1;
            }],
        ]);

        $this->assertEquals(2, $match(Maybe::just(1)));
    }

    public function testThatCanMatchOnNothing()
    {
        $match = Pattern::match([
            [Pattern::nothing(), function () {
                return 'nothing';
            }],
        ]);

        $this->assertEquals('nothing', $match(Maybe::nothing()));
    }

    public function testThatCanMatchUsingLambdaAlways()
    {
        $match = Pattern::match([
            [Lambda::always(), function () {
                return 'always';
            }],
        ]);

        $this->assertEquals('always', $match('w/e'));
    }

    public function testThatCanMatchOnValuesUsingLogic()
    {
        $match = Pattern::match([
            [Logic::eqStrict(1), function () {
                return 'yep';
            }],
        ]);

        $this->assertEquals('yep', $match(1));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThatThrowsOnNonCallable()
    {
        $match = Pattern::match([
            [1, function () {
                return 'yep';
            }],
        ]);

        $this->assertEquals('yep', $match(1));
    }

    /**
     * @expectedException \Vector\Core\Exception\IncompletePatternMatchException
     */
    public function testThatThrowsOnNoMatchingPattern()
    {
        $match = Pattern::match([
            [Pattern::just(), function ($value) {
                return $value + 1;
            }],
        ]);

        $this->assertEquals(2, $match(1));
    }
}
