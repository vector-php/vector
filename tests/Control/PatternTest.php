<?php

namespace Vector\Test\Control;

use PHPUnit\Framework\TestCase;
use Vector\Control\Pattern;
use Vector\Core\Exception\IncompletePatternMatchException;
use Vector\Core\Exception\InvalidPatternMatchException;
use Vector\Data\Maybe\Just;
use Vector\Data\Maybe\Maybe;
use Vector\Data\Maybe\Nothing;
use Vector\Data\Result\Err;
use Vector\Data\Result\Ok;
use Vector\Data\Result\Result;
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
            fn(int $a) => 1,
            fn(int $a, int $b) => 2,
        ]);

        $this->assertEquals(2, $match(2, 2));
        $this->assertEquals(1, $match(1));
    }

    public function testThatItMatchesOnType()
    {
        $match = Pattern::match([
            fn(string $value) => 1,
            fn(int $value) => 2,
        ]);

        $this->assertEquals(1, $match('hello'));
        $this->assertEquals(2, $match(1));
    }

    public function testThatCanMatchOnResultOk()
    {
        $match = Pattern::match([
            fn(Ok $value) => fn(int $value) => $value + 2,
            fn(Err $error) => 'nothing',
        ]);

        $this->assertEquals(3, $match(Result::ok(1)));
    }

    public function testThatCanMatchOnResultErr()
    {
        $match = Pattern::match([
            fn(Ok $value) => fn(int $value) => $value + 2,
            fn(Err $error) => fn(string $error) => $error,
        ]);

        $this->assertEquals("something wen't wrong.", $match(Result::err("something wen't wrong.")));
    }

    public function testThatCanMatchOnMaybeJust()
    {
        $match = Pattern::match([
            fn(Just $value) => fn(int $value) => $value + 2,
            fn(Nothing $_) => 'nothing',
        ]);

        $this->assertEquals(3, $match(Maybe::just(1)));
    }

    public function testThatCanHaveDefaultCase()
    {
        $match = Pattern::match([
            fn(Just $value) => fn(int $value) => $value + 2,
            fn() => fn() => 'default',
        ]);

        $this->assertEquals('default', $match(Maybe::nothing()));
    }

    public function testThatCanMatchOnMaybeNothing()
    {
        $match = Pattern::match([
            fn(Just $value) => fn(int $value) => $value + 2,
            fn(Nothing $_) => fn() => 'nothing',
        ]);

        $this->assertEquals('nothing', $match(Maybe::nothing()));
    }

    public function testThatCanMatchOnExtractable()
    {
        $match = Pattern::match([
            fn(TestChildTypeA $value) => fn(int $value) => $value + 1,
            fn(TestChildTypeB $value) => fn(int $value) => $value + 2,
        ]);

        $this->assertEquals(3, $match(TestParentType::typeB(1)));
    }

    public function testThatThrowsWhenNonCallbackValueForWrappedMatch()
    {
        $this->expectException(InvalidPatternMatchException::class);

        $match = Pattern::match([
            fn(TestExtractableObject $a) => 'need callback',
        ]);

        $this->assertEquals('always', $match(new TestExtractableObject(1)));
    }

    public function testThatCanMatchUsingEmptyParams()
    {
        $match = Pattern::match([
            fn() => 'always',
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
            fn(TestObject $object) => $object->getValue(),
        ]);

        $this->assertEquals('works', $match(new TestObject()));
    }

    public function testThatCanMatchArityOnCustomObjects()
    {
        $match = Pattern::match([
            fn(TestObject $object) => $object->getValue(),
            fn(TestObject $object, TestObject $object2) => 'ok',
        ]);

        $this->assertEquals('ok', $match(new TestObject(), new TestObject()));
    }

    public function testThatThrowsOnNoMatchingPattern()
    {
        $this->expectException(IncompletePatternMatchException::class);

        $match = Pattern::match([
            fn(string $value) => $value . 'asdf',
        ]);

        $this->assertEquals(2, $match(1));
    }
}
