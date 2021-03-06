<?php

namespace Vector\Test\Control;

use PHPUnit\Framework\TestCase;
use Vector\Control\Pattern;
use Vector\Core\Exception\IncompletePatternMatchException;
use Vector\Data\Maybe\Just;
use Vector\Data\Maybe\Maybe;
use Vector\Data\Maybe\Nothing;
use Vector\Data\Result\Err;
use Vector\Data\Result\Ok;
use Vector\Data\Result\Result;
use Vector\Lib\Strings;
use Vector\Test\Control\Stub\TestChildTypeA;
use Vector\Test\Control\Stub\TestChildTypeB;
use Vector\Test\Control\Stub\TestExtractableObject;
use Vector\Test\Control\Stub\TestObject;
use Vector\Test\Control\Stub\TestParentType;

class PatternTest extends TestCase
{
    /** @test */
    function it_matches_arity_when_no_arguments_are_given()
    {
        $match = Pattern::match([
            fn (int $a) => 1,
            fn (int $a, int $b) => 2,
        ]);

        $this->assertEquals(2, $match(2, 2));
        $this->assertEquals(1, $match(1));
    }

    /** @test */
    function it_matches_on_type()
    {
        $match = Pattern::match([
            fn (string $value) => 1,
            fn (int $value) => 2,
        ]);

        $this->assertEquals(1, $match('hello'));
        $this->assertEquals(2, $match(1));
    }

    /** @test */
    function it_can_match_on_result_ok()
    {
        $match = Pattern::match([
            fn (Ok $value) => fn (string $value) => $value . 'bc',
            fn (Err $error) => 'nothing',
        ]);

        $this->assertEquals('abc', $match(Result::ok('a')));
    }

    /** @test */
    function it_can_match_on_result_err()
    {
        $match = Pattern::match([
            fn (Ok $value) => fn (int $value) => $value + 2,
            fn (Err $error) => fn ($error) => $error,
        ]);

        $this->assertEquals("something wen't wrong.", $match(Result::err("something wen't wrong.")));
    }

    /** @test */
    function it_can_match_on_maybe_just()
    {
        $match = Pattern::match([
            fn (Just $value) => fn (string $value) => $value . 'bc',
            fn (Nothing $_) => 'nothing',
        ]);

        $this->assertEquals('abc', $match(Maybe::just('a')));
    }

    /** @test */
    function it_can_match_on_default_case()
    {
        $match = Pattern::match([
            fn (Just $value) => $value + 2,
            fn () => 'default',
        ]);

        $this->assertEquals('default', $match(Maybe::nothing()));
    }

    /** @test */
    function it_can_match_on_maybe_nothing()
    {
        $match = Pattern::match([
            fn (Just $value) => $value,
            fn (Nothing $_) => 'nothing',
        ]);

        $this->assertEquals('nothing', $match(Maybe::nothing()));
    }

    /** @test */
    function it_can_match_on_extractable()
    {
        $match = Pattern::match([
            fn (TestChildTypeA $value) => Strings::concat('no'),
            fn (TestChildTypeB $value) => Strings::concat('bc'),
        ]);

        $this->assertEquals('abc', $match(TestParentType::typeB('a')));
    }

    /** @test */
    function it_can_auto_return_a_scalar_from_a_wrapped_match()
    {
        $match = Pattern::match([
            fn (TestExtractableObject $a) => 'string-value',
        ]);

        $this->assertEquals('string-value', $match(new TestExtractableObject('a')));
    }

    /** @test */
    function it_auto_calls_a_matched_callable_value()
    {
        $match = Pattern::match([
            fn (TestExtractableObject $a) => fn ($a) => $a . 'bc',
        ]);

        $this->assertEquals('abc', $match(new TestExtractableObject('a')));
    }

    /** @test */
    function can_match_using_empty_params()
    {
        $match = Pattern::match([
            fn () => 'always',
        ]);

        $this->assertEquals('always', $match('w/e'));
    }

    /** @test */
    function switch_case_for_raw_values()
    {
        $match = function ($value) {
            switch ($value) {
                case [1, 3]:
                    return 'a';
                case [1, 2, 3]:
                    return true;
                default:
                    return false;
            }
        };

        $this->assertEquals(true, $match([1, 2, 3]));
    }

    /** @test */
    function can_match_on_custom_object()
    {
        $match = Pattern::match([
            fn (TestObject $object) => $object->getValue(),
        ]);

        $this->assertEquals('works', $match(new TestObject));
    }

    /** @test */
    function it_can_match_arity_on_custom_objects()
    {
        $match = Pattern::match([
            fn (TestObject $object) => $object->getValue(),
            fn (TestObject $object, TestObject $object2) => 'ok',
        ]);

        $this->assertEquals('ok', $match(new TestObject, new TestObject));
    }

    /** @test */
    function it_uses_first_match_arity_on_optional_params()
    {
        $matchTest1 = Pattern::match([
            fn (TestObject $object) => 'first',
            fn (TestObject $object, ?TestObject $object2) => 'second',
            fn (TestObject $object, TestObject $object2 = null) => 'third',
        ]);

        $matchTest2 = Pattern::match([
            fn (TestObject $object) => 'first',
            fn (TestObject $object, TestObject $object2 = null) => 'second',
            fn (TestObject $object, TestObject $object2) => 'third',
        ]);

        $this->assertEquals('second', $matchTest1(new TestObject, new TestObject));
        $this->assertEquals('second', $matchTest2(new TestObject, new TestObject));
    }

    /** @test */
    function throws_on_no_matching_pattern()
    {
        $this->expectException(IncompletePatternMatchException::class);

        $match = Pattern::match([
            fn (string $value) => $value . 'asdf',
        ]);

        $this->assertEquals(2, $match(1));
    }
}
