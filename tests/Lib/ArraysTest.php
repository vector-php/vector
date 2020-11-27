<?php

namespace Vector\Test\Lib;

use PHPUnit\Framework\TestCase;
use Vector\Data\Maybe\Maybe;
use Vector\Lib\Arrays;

class ArraysTest extends TestCase
{
    protected $testCase;

    function setUp(): void
    {
        $this->testCase = [0, 1, 2, 3];
    }

    /** @test */
    function sort_does_not_mutate()
    {
        $comp = function ($a, $b) {
            if ($a == $b) {
                return 0;
            }
            return ($a < $b) ? -1 : 1;
        };

        $arr = [3, 2, 1];

        $this->assertEquals([1, 2, 3], Arrays::sort($comp, $arr));
        $this->assertEquals([3, 2, 1], $arr);
    }

    /** @test */
    function immutable_cons()
    {
        $this->assertEquals([0, 1, 2, 3, 4], Arrays::cons(4, $this->testCase));
        $this->assertEquals([1], Arrays::cons(1, []));
        $this->assertEquals([0, 1, 2, 3], $this->testCase);
    }

    /** @test */
    function head_first_of_list()
    {
        $this->assertEquals(Maybe::just(0), Arrays::head($this->testCase));
    }

    /** @test */
    function head_returns_first_element_non_numeric_indexed()
    {
        $this->assertEquals(Maybe::just('works'), Arrays::head(['test' => 'works', 'another' => 'test', 'ok' => 1]));
    }


    /** @test */
    function head_returns_nothing_on_empty_list()
    {
        $this->assertEquals(Maybe::nothing(), Arrays::head([]));
    }

    /** @test */
    function tail()
    {
        $this->assertEquals([1, 2, 3], Arrays::tail($this->testCase));
    }

    /** @test */
    function init()
    {
        $this->assertEquals([0, 1, 2], Arrays::init($this->testCase));
    }

    /** @test */
    function last()
    {
        $this->assertEquals(Maybe::just(3), Arrays::last($this->testCase));
    }

    /** @test */
    function last_returns_nothing_on_empty_list()
    {
        $this->assertEquals(Maybe::nothing(), Arrays::last([]));
    }

    /** @test */
    function length()
    {
        $this->assertEquals(4, Arrays::length($this->testCase));
    }

    /** @test */
    function index_returns_element_at_index_as_just()
    {
        $this->assertEquals(Maybe::just(2), Arrays::index(2, $this->testCase));
    }

    /** @test */
    function index_with_default_returns_value()
    {
        $array = [
            'first' => [
                'second' => [
                    'third' => 'final!',
                ],
            ],
        ];

        $answer = vector($array)
            ->pipe(Arrays::index('first'))
            ->pipe(Maybe::map(Arrays::index('second')))
            ->pipe(Maybe::map(Arrays::index('third')))
            ->pipe(Maybe::withDefault('not found'))();

        $this->assertEquals('final!', $answer);
    }

    /** @test */
    function index_returns_just_null_value_if_that_is_the_actual_value()
    {
        $this->assertEquals(Maybe::just(null), Arrays::index(0, [null]));
    }

    /** @test */
    function index_returns_nothing_for_missing_key()
    {
        $this->assertEquals(Maybe::nothing(), Arrays::index(17, [1, 2, 3]));
    }

    /** @test */
    function map_indexed()
    {
        $list = [1, 2, 3];

        $result = Arrays::mapIndexed(function ($value, $index) {
            return [$value, $index];
        }, $list);

        $this->assertEquals([
            [1, 0],
            [2, 1],
            [3, 2]
        ], $result);
    }

    /** @test */
    function test_concat()
    {
        $this->assertEquals([0, 1, 2, 3, 0, 1, 2, 3], Arrays::concat($this->testCase, $this->testCase));
        $this->assertEquals(['foo' => 1, 'bar' => 2], Arrays::concat(['foo' => 1], ['bar' => 2]));
        $this->assertEquals(['foo' => 'baz', 'bar' => 2], Arrays::concat(['foo' => 1, 'bar' => 2], ['foo' => 'baz']));
    }

    /** @test */
    function set_index_is_immutable()
    {
        $this->assertEquals([0, 1, 0, 3], Arrays::setIndex(2, 0, $this->testCase));
        $this->assertEquals([0, 1, 2, 3], $this->testCase);
    }

    /** @test */
    function keys()
    {
        $this->assertEquals([0, 1, 2], Arrays::keys([5, 5, 5]));
        $this->assertEquals(['foo', 'bar', 'baz'], Arrays::keys(['foo' => 1, 'bar' => 2, 'baz' => 3]));
    }

    /** @test */
    function values()
    {
        $this->assertEquals([1, 2, 3], Arrays::values([1, 2, 3]));
        $this->assertEquals([1, 2, 3], Arrays::values(['foo' => 1, 'bar' => 2, 'baz' => 3]));
    }

    /** @test */
    function filter()
    {
        $id = function ($a) {
            return true;
        };
        $gt = function ($b) {
            return $b >= 2;
        };

        $this->assertEquals([0, 1, 2, 3], Arrays::filter($id, $this->testCase));
        $this->assertEquals([2 => 2, 3 => 3], Arrays::filter($gt, $this->testCase));
    }

    /** @test */
    function zip_with_on_unequal_length()
    {
        $combinator = function ($a, $b) {
            return $a + $b;
        };

        $this->assertEquals([1, 2, 3], Arrays::zipWith($combinator, [5, 5, 5], [-4, -3, -2]));
        $this->assertequals([0], Arrays::zipWith($combinator, [5, 5, 5], [-5]));
        $this->assertequals([5], Arrays::zipWith($combinator, [5], [0, 5, 5]));
        $this->assertEquals([], Arrays::zipWith($combinator, [], [1, 2, 3]));

        // Test that it ignore keys
        $this->assertEquals([2, 4], Arrays::zipWith($combinator, ['foo' => 1, 'bar' => 2], [1 => 1, 5 => 2]));
    }

    /** @test */
    function reduce()
    {
        $reducer = function ($a, $b) {
            return $a + $b;
        };

        $this->assertEquals(6, Arrays::reduce($reducer, 0, [1, 2, 3]));
    }

    /** @test */
    function drop()
    {
        $this->assertequals([1, 2, 3], Arrays::drop(3, [0, 0, 0, 1, 2, 3]));
        $this->assertequals([1, 2], Arrays::drop(0, [1, 2]));
        $this->assertequals([], Arrays::drop(5, [1, 2, 3]));
    }

    /** @test */
    function drop_while()
    {
        $lteThree = function ($n) {
            return $n <= 3;
        };
        $divByTwo = function ($n) {
            return $n % 2 == 0;
        };

        $this->assertEquals([4, 5], Arrays::dropWhile($lteThree, [1, 2, 3, 4, 5]));
        $this->assertEquals([1, 2, 3], Arrays::dropWhile($divByTwo, [0, 2, 4, 6, 1, 2, 3]));
        $this->assertEquals([], Arrays::dropWhile($divByTwo, [2, 4, 6]));
        $this->assertEquals([1, 3, 5], Arrays::dropWhile($divByTwo, [1, 3, 5]));
    }

    /** @test */
    function take()
    {
        $this->assertEquals([1, 2, 3], Arrays::take(3, [1, 2, 3, 4, 5]));
        $this->assertEquals([], Arrays::take(0, [1, 2, 3, 4, 5]));
        $this->assertEquals([1, 2, 3], Arrays::take(10, [1, 2, 3]));
    }

    /** @test */
    function take_while()
    {
        $lteThree = function ($n) {
            return $n <= 3;
        };
        $divByTwo = function ($n) {
            return $n % 2 == 0;
        };

        $this->assertEquals([1, 2, 3], Arrays::takeWhile($lteThree, [1, 2, 3, 4, 5]));
        $this->assertEquals([], Arrays::takeWhile($divByTwo, [1, 2, 4, 6]));
    }

    /** @test */
    function reverse()
    {
        $arr = [1, 2, 3];

        $this->assertEquals([3, 2, 1], Arrays::reverse($arr));
        $this->assertEquals([1, 2, 3], $arr);
    }

    /** @test */
    function flatten()
    {
        $testCase1 = [1, [2], [[3, 4]], [5, [6]], 7];
        $testCase2 = [1, 2, 3, [[[[[[[]]]]]]]];

        $this->assertEquals([1, 2, 3, 4, 5, 6, 7], Arrays::flatten($testCase1));
        $this->assertEquals([1, 2, 3], Arrays::flatten($testCase2));
    }

    /**
     *
     */
    function contains_true_and_false()
    {
        $this->assertEquals(true, Arrays::contains(1, [1, 2, 3]));
        $this->assertEquals(false, Arrays::contains(5, [1, 2, 3]));
    }

    /** @test */
    function replicate()
    {
        $this->assertEquals([1, 1, 1], Arrays::replicate(3, 1));
        $this->assertEquals([], Arrays::replicate(0, 'foo'));
    }

    /** @test */
    function group_by_on_array()
    {
        $testCase = [1, 2, 3, 4, 5, 6, 7];
        $correctAnswer = ['even' => [2, 4, 6], 'odd' => [1, 3, 5, 7]];

        $keyGen = function ($a) {
            return ($a % 2 == 0) ? 'even' : 'odd';
        };

        $this->assertEquals($correctAnswer, Arrays::groupBy($keyGen, $testCase));
    }

    /** @test */
    function group_by_on_object()
    {
        $testCase = [
            ['foo' => 'bar', 'value' => 1],
            ['foo' => 'bar', 'value' => 2],
            ['foo' => 'baz', 'value' => 3],
            ['value' => 8],
        ];
        $correctAnswer = [
            'bar' => [
                ['foo' => 'bar', 'value' => 1],
                ['foo' => 'bar', 'value' => 2],
            ],
            'baz' => [
                ['foo' => 'baz', 'value' => 3],
            ],
            "doesn't have foo" => [
                ['value' => 8],
            ],
        ];

        $this->assertEquals($correctAnswer, Arrays::groupBy(
            fn($val) => vector($val)->pipe(Arrays::index('foo'))->pipe(Maybe::withDefault("doesn't have foo"))(),
            $testCase
        ));
    }

    /** @test */
    function unique()
    {
        $this->assertEquals(
            [1, 2, 4],
            Arrays::unique([1, 2, 2, 4])
        );
    }

    /** @test */
    function take_last()
    {
        $this->assertEquals(
            [2, 4],
            Arrays::takeLast(2, [1, 1, 2, 4])
        );
    }

    /** @test */
    function zip_simple_arrays()
    {
        $a = [1, 2, 3];
        $b = ['a', 'b', 'c'];

        $this->assertEquals(
            [[1, 'a'], [2, 'b'], [3, 'c']],
            Arrays::zip($a, $b)
        );
    }

    /** @test */
    function zip_hard_arrays()
    {
        $a = [1, 2, 3];
        $c = [[1, 0], [2, 0], [3, 1]];

        $this->assertEquals(
            [[1, [1, 0]], [2, [2, 0]], [3, [3, 1]]],
            Arrays::zip($a, $c)
        );
    }

    /** @test */
    function first_can_find_element()
    {
        $isEven = function ($a) {
            return $a % 2 == 0;
        };
        $numbers = [1, 5, 7, 4, 9];

        $this->assertEquals(
            Maybe::just(4),
            Arrays::first($isEven, $numbers)
        );
    }

    /** @test */
    function first_returns_nothing_when_no_match_found()
    {
        $isEven = function ($a) {
            return $a % 2 == 0;
        };
        $numbers = [1, 5, 7, 11, 9];

        $this->assertEquals(Maybe::nothing(), Arrays::first($isEven, $numbers));
    }

    /** @test */
    function bifurcate()
    {
        $isEven = function ($a) {
            return $a % 2 == 0;
        };
        $numbers = [1, 5, 7, 4, 9];

        $this->assertEquals(
            [[4], [1, 5, 7, 9]],
            Arrays::bifurcate($isEven, $numbers)
        );
    }
}
