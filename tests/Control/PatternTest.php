<?php

namespace Vector\Test\Control;

use PHPUnit\Framework\TestCase;
use Vector\Control\Pattern;
use Vector\Test\Control\Stub\TestChildTypeA;
use Vector\Test\Control\Stub\TestChildTypeB;
use Vector\Test\Control\Stub\TestExtractableObject;
use Vector\Test\Control\Stub\TestObject;
use Vector\Test\Control\Stub\TestParentType;

/**
 * Class PatternTest
 * @package Vector\Test\Control
 */
class PatternTest extends TestCase
{
    /**
     * Tests the we have an informative error when no arguments are given
     */
    public function testThatItMatchesOnArity()
    {
        $match = Pattern::match([
            function (int $a) {
                return 1;
            },
            function (int $a, int $b) {
                return 2;
            },
        ]);

        $this->assertEquals(2, $match(2, 2));
        $this->assertEquals(1, $match(1));
    }

    public function testThatItMatchesOnType()
    {
        $match = Pattern::match([
            function (string $value) {
                return 1;
            },
            function (int $value) {
                return 2;
            },
        ]);

        $this->assertEquals(1, $match('hello'));
        $this->assertEquals(2, $match(1));
    }

    public function testThatCanMatchOnEitherRight()
    {
        $match = Pattern::match([
            function (TestChildTypeA $value) {
                return function (int $value) {
                    return $value + 1;
                };
            },
            function (TestChildTypeB $value) {
                return function (int $value) {
                    return $value + 2;
                };
            },
        ]);

        $this->assertEquals(3, $match(TestParentType::typeB(1)));
    }

    /**
     * @expectedException \Vector\Core\Exception\InvalidPatternMatchException
     */
    public function testThatThrowsWhenNonCallbackValueForWrappedMatch()
    {
        $match = Pattern::match([
            function (TestExtractableObject $a) {
                return 'need callback';
            },
        ]);

        $this->assertEquals('always', $match(new TestExtractableObject(1)));
    }

    public function testThatCanMatchUsingEmptyParams()
    {
        $match = Pattern::match([
            function () {
                return 'always';
            },
        ]);

        $this->assertEquals('always', $match('w/e'));
    }

    /**
     * Use php for things you can use php for.
     */
    public function testThatCanMatchOnExplicitValues()
    {
        $match = function ($value) {
            switch ($value) {
                case [1, 3]:
                    return false;
                case [1, 2, 3]:
                    return true;
                default:
                    return false;
            }
        };

        $this->assertEquals(true, $match([1, 2, 3]));
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

    public function testThatCanMatchArityOnCustomObjects()
    {
        $match = Pattern::match([
            function (TestObject $object) {
                return $object->getValue();
            },
            function (TestObject $object1, TestObject $object2) {
                return 'ok';
            },
        ]);

        $this->assertEquals('ok', $match(new TestObject(), new TestObject()));
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
