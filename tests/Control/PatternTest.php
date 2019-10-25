<?php

namespace Vector\Test\Control;

use PHPUnit\Framework\TestCase;
use Vector\Control\Pattern;
use Vector\Core\Exception\IncompletePatternMatchException;
use Vector\Core\Exception\InvalidPatternMatchException;
use Vector\Core\Module;
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

class PatternTest extends TestCase
{
    /** @test */
    public function it_matches_arity_when_no_arguments_are_given()
    {
        $match = Pattern::match([
            fn (int $a) => 1,
            fn (int $a, int $b) => 2,
        ]);

        $this->assertEquals(2, $match(2, 2));
        $this->assertEquals(1, $match(1));
    }

    /** @test */
    public function it_matches_on_type()
    {
        $match = Pattern::match([
            fn (string $value) => 1,
            fn (int $value) => 2,
        ]);

        $this->assertEquals(1, $match('hello'));
        $this->assertEquals(2, $match(1));
    }

    /** @test */
    public function it_can_match_on_result_ok()
    {
        $match = Pattern::match([
            fn (Ok $value) => fn (int $value) => $value + 2,
            fn (Err $error) => 'nothing',
        ]);

        $this->assertEquals(3, $match(Result::ok(1)));
    }

    /** @test */
    public function it_can_match_on_result_err()
    {
        $match = Pattern::match([
            fn (Ok $value) => fn (int $value) => $value + 2,
            fn (Err $error) => fn (string $error) => $error,
        ]);

        $this->assertEquals("something wen't wrong.", $match(Result::err("something wen't wrong.")));
    }

    /** @test */
    public function it_can_match_on_maybe_just()
    {
        $match = Pattern::match([
            fn (Just $value) => $value + 2,
            fn (Nothing $_) => 'nothing',
        ]);

        $this->assertEquals(3, $match(Maybe::just(1)));
    }

    /** @test */
    public function it_can_match_on_default_case()
    {
        $match = Pattern::match([
            fn (Just $value) => $value + 2,
            fn () => 'default',
        ]);

        $this->assertEquals('default', $match(Maybe::nothing()));
    }

    /** @test */
    public function it_can_match_on_maybe_nothing()
    {
        $match = Pattern::match([
            fn (Just $value) => $value + 2,
            fn (Nothing $_) => 'nothing',
        ]);

        $this->assertEquals('nothing', $match(Maybe::nothing()));
    }

    /** @test */
    public function it_can_match_on_extractable()
    {
        $match = Pattern::match([
            fn (TestChildTypeA $value) => $value + 1,
            fn (TestChildTypeB $value) => $value + 2,
        ]);

        $this->assertEquals(3, $match(TestParentType::typeB(1)));
    }

    /** @test */
    public function it_can_auto_unwrap_a_wrapped_match()
    {
        $match = Pattern::match([
            fn (TestExtractableObject $a) => 'value',
        ]);

        $this->assertEquals('value', $match(new TestExtractableObject(1)));
    }

    /** @test */
    public function it_auto_calls_a_matched_callable_value()
    {
        $match = Pattern::match([
            fn (TestExtractableObject $a) => fn ($a) => $a + 1,
        ]);

        $this->assertEquals(2, $match(new TestExtractableObject(1)));
    }

    /** @test */
    public function can_match_using_empty_params()
    {
        $match = Pattern::match([
            fn () => 'always',
        ]);

        $this->assertEquals('always', $match('w/e'));
    }

    /** @test */
    public function switch_case_for_raw_values()
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
    public function can_match_on_custom_object()
    {
        $match = Pattern::match([
            fn (TestObject $object) => $object->getValue(),
        ]);

        $this->assertEquals('works', $match(new TestObject()));
    }

    /** @test */
    public function it_can_match_arity_on_custom_objects()
    {
        $match = Pattern::match([
            fn (TestObject $object) => $object->getValue(),
            fn (TestObject $object, TestObject $object2) => 'ok',
        ]);

        $this->assertEquals('ok', $match(new TestObject(), new TestObject()));
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
