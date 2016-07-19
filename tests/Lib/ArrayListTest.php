<?php

namespace Vector\Test\Lib;

use Vector\Core\Exception\EmptyListException;
use Vector\Core\Exception\IndexOutOfBoundsException;

use Vector\Lib\ArrayList;
use Vector\Data\Maybe;

class ArrayListTest extends \PHPUnit_Framework_TestCase
{
    protected $testCase;

    protected function setUp()
    {
        $this->testCase = [0, 1, 2, 3];
    }

    public function testSort()
    {
        $sort = ArrayList::using('sort');

        $comp = function ($a, $b) {
            if ($a == $b) {
                return 0;
            }
            return ($a < $b) ? -1 : 1;
        };

        $arr = [3, 2, 1];

        $this->assertEquals($sort($comp, $arr), [1, 2, 3]);
        $this->assertEquals($arr, [3, 2, 1]);
    }

    /**
     * Test that cons appends to array and is immutable
     */
    public function testConsOperator()
    {
        $cons = ArrayList::using('cons');

        $this->assertEquals($cons(4, $this->testCase), [0, 1, 2, 3, 4]);
        $this->assertEquals($cons(1, []), [1]);
        $this->assertEquals([0, 1, 2, 3], $this->testCase);
    }

    /**
     * Tests that head returns the first element of a list
     */
    public function testHead_returnsFirstElement()
    {
        $head = ArrayList::Using('head');

        $this->assertEquals($head($this->testCase), 0);
    }

    /**
     * Expect that an EmptyListException is thrown for head on empty lists
     */
    public function testHead_undefinedOnEmptyList()
    {
        $head = ArrayList::Using('head');
        $this->expectException(EmptyListException::class);

        $head([]); // Throws Exception
    }

    /**
     * Test that tail returns the rest of a list sans first element
     */
    public function testTail()
    {
        $tail = ArrayList::Using('tail');

        $this->assertEquals($tail($this->testCase), [1, 2, 3]);
    }

    /**
     * Test that init returns the first chunk of an array
     */
    public function testInit()
    {
        $init = ArrayList::Using('init');

        $this->assertEquals($init($this->testCase), [0, 1, 2]);
    }

    /**
     * Test that last returns the last element of a list
     */
    public function testLast_returnsLastElement()
    {
        $last = ArrayList::Using('last');

        $this->assertEquals($last($this->testCase), 3);
    }

    /**
     * Expect that an EmptyListException is thrown for last on empty lists
     */
    public function testLast_undefinedOnEmptyList()
    {
        $last = ArrayList::Using('last');
        $this->expectException(EmptyListException::class);

        $last([]); // Throws Exception
    }

    /**
     * Test that length returns the length of a list
     */
    public function testLength()
    {
        $length = ArrayList::Using('length');

        $this->assertEquals($length($this->testCase), 4);
    }

    /**
     * Test that index returns the element of a list at the given index
     */
    public function testIndex_returnsElementAtIndex()
    {
        $index = ArrayList::Using('index');

        $this->assertEquals($index(2, $this->testCase), 2);
    }

    /**
     * Test that index returns existant index, even if the value is null
     */
    public function testIndex_returnsNullValue()
    {
        $index = ArrayList::Using('index');

        $this->assertEquals($index(0, [null]), null);
    }

    /**
     * Test that index throws an exception when requesting a non-existant index
     */
    public function testIndex_throwsExceptionForNoKey()
    {
        $index = ArrayList::Using('index');
        $this->expectException(IndexOutOfBoundsException::class);

        $index(17, [1, 2, 3]);
    }

    /**
     * Test that mapIndexed receives an index
     */
    public function test_mapIndexed()
    {
        $mapIndexed = ArrayList::Using('mapIndexed');

        $list = [1, 2, 3];

        $result = $mapIndexed(function ($value, $index) {
            return [$value, $index];
        }, $list);

        $this->assertEquals([
            [1, 0],
            [2, 1],
            [3, 2]
        ], $result);
    }

    /**
     * Test that concat handles normal arrays, and key/value arrays properly
     */
    public function testConcat()
    {
        $concat = ArrayList::Using('concat');

        $this->assertEquals([0, 1, 2, 3, 0, 1, 2, 3], $concat($this->testCase, $this->testCase));
        $this->assertEquals(['foo' => 1, 'bar' => 2], $concat(['foo' => 1], ['bar' => 2]));
        $this->assertEquals(['foo' => 'baz', 'bar' => 2], $concat(['foo' => 1, 'bar' => 2], ['foo' => 'baz']));
    }

    /**
     * Test that set properly sets the value of an array at the index in an
     * immutable way
     */
    public function testSet()
    {
        $set = ArrayList::Using('setIndex');

        $this->assertEquals($set(2, 0, $this->testCase), [0, 1, 0, 3]);
        $this->assertEquals($this->testCase, [0, 1, 2, 3]);
    }

    /**
     * Test that keys returns the keys of a key/value array
     */
    public function testKeys()
    {
        $keys = ArrayList::using('keys');

        $this->assertEquals([0, 1, 2], $keys([5, 5, 5]));
        $this->assertEquals(['foo', 'bar', 'baz'], $keys(['foo' => 1, 'bar' => 2, 'baz' => 3]));
    }

    /**
     * Test that values returns key/value array values
     */
    public function testValues()
    {
        $values = ArrayList::using('values');

        $this->assertEquals([1, 2, 3], $values([1, 2, 3]));
        $this->assertEquals([1, 2, 3], $values(['foo' => 1, 'bar' => 2, 'baz' => 3]));
    }

    /**
     * Test that the filter function correctly filters an array of data
     */
    public function testFilter()
    {
        $filter = ArrayList::using('filter');

        $id = function($a) { return true; };
        $gt = function($b) { return $b >= 2; };

        $this->assertEquals([0, 1, 2, 3], $filter($id, $this->testCase));
        $this->assertEquals([2 => 2, 3 => 3], $filter($gt, $this->testCase));
    }

    /**
     * Test that the zipWith function works properly, specifically the cases
     * where it is given arrays of unequal length
     */
    public function testZipWith()
    {
        $zipWith = ArrayList::using('zipWith');

        $combinator = function($a, $b) { return $a + $b; };

        $this->assertEquals([1, 2, 3], $zipWith($combinator, [5, 5, 5], [-4, -3, -2]));
        $this->assertequals([0], $zipWith($combinator, [5, 5, 5], [-5]));
        $this->assertequals([5], $zipWith($combinator, [5], [0, 5, 5]));
        $this->assertEquals([], $zipWith($combinator, [], [1, 2, 3]));

        // Test that it ignore keys
        $this->assertEquals([2, 4], $zipWith($combinator, ['foo' => 1, 'bar' => 2], [1 => 1, 5 => 2]));
    }

    /**
     * Tests foldl by reducing an array with an add function
     */
    public function testFoldL()
    {
        $foldl = ArrayList::using('foldl');

        $reducer = function($a, $b) { return $a + $b; };

        $this->assertEquals(6, $foldl($reducer, 0, [1, 2, 3]));
    }

    /**
     * Tests that the drop function returns arrays without the leading elements
     */
    public function testDrop()
    {
        $drop = ArrayList::using('drop');

        $this->assertequals([1, 2, 3], $drop(3, [0, 0, 0, 1, 2, 3]));
        $this->assertequals([1, 2], $drop(0, [1, 2]));
        $this->assertequals([], $drop(5, [1, 2, 3]));
    }

    /**
     * Dropwhile should return every element after the first element in a list
     * returns false for the predicate
     */
    public function testDropWhile()
    {
        $dropWhile = ArrayList::using('dropWhile');

        $lteThree = function($n) { return $n <= 3; };
        $divByTwo = function($n) { return $n % 2 == 0; };

        $this->assertEquals([4, 5], $dropWhile($lteThree, [1, 2, 3, 4, 5]));
        $this->assertEquals([1, 2, 3], $dropWhile($divByTwo, [0, 2, 4, 6, 1, 2, 3]));
        $this->assertEquals([], $dropWhile($divByTwo, [2, 4, 6]));
        $this->assertEquals([1, 3, 5], $dropWhile($divByTwo, [1, 3, 5]));
    }

    /**
     * Take should return the first n elements of an array
     */
    public function testTake()
    {
        $take = ArrayList::using('take');

        $this->assertEquals([1, 2, 3], $take(3, [1, 2, 3, 4, 5]));
        $this->assertEquals([], $take(0, [1, 2, 3, 4, 5]));
        $this->assertEquals([1, 2, 3], $take(10, [1, 2, 3]));
    }

    /**
     * TakeWhile should return the first elements of the array until the predicate returns
     * false
     */
    public function testTakeWhile()
    {
        $takeWhile = ArrayList::using('takeWhile');

        $lteThree = function($n) { return $n <= 3; };
        $divByTwo = function($n) { return $n % 2 == 0; };

        $this->assertEquals([1, 2, 3], $takeWhile($lteThree, [1, 2, 3, 4, 5]));
        $this->assertEquals([], $takeWhile($divByTwo, [1, 2, 4, 6]));
    }

    /**
     * Reverse should flip an array and not modify the original array
     */
    public function testReverse()
    {
        $reverse = ArrayList::using('reverse');

        $arr = [1, 2, 3];

        $this->assertEquals([3, 2, 1], $reverse($arr));
        $this->assertEquals([1, 2, 3], $arr);
    }

    /**
     * Flatten should take a multidimensional array and turn it into a single
     * dimensional array
     */
    public function testFlatten()
    {
        $flatten = ArrayList::using('flatten');

        $testCase1 = [1, [2], [[3, 4]], [5, [6]], 7];
        $testCase2 = [1, 2, 3, [[[[[[[]]]]]]]];

        $this->assertEquals([1, 2, 3, 4, 5, 6, 7], $flatten($testCase1));
        $this->assertEquals([1, 2, 3], $flatten($testCase2));
    }

    /**
     * Contains should return true if the given list contains the given value
     */
    public function testContains()
    {
        $contains = ArrayList::using('contains');

        $this->assertEquals(true, $contains(1, [1, 2, 3]));
        $this->assertEquals(false, $contains(5, [1, 2, 3]));
    }

    /**
     * Replicate should repeat an item n times
     */
    public function testReplicate()
    {
        $replicate = ArrayList::using('replicate');

        $this->assertEquals([1, 1, 1], $replicate(3, 1));
        $this->assertEquals([], $replicate(0, 'foo'));
    }

    /**
     * Group By should create groups from lists
     */
    public function testGroupBy()
    {
        // Test a simple keygen
        $groupBy = ArrayList::using('groupBy');

        $testCase = [1, 2, 3, 4, 5, 6, 7];
        $correctAnswer = ['even' => [2, 4, 6], 'odd' => [1, 3, 5, 7]];

        $keyGen = function($a) {
            return ($a % 2 == 0) ? 'even' : 'odd';
        };

        $this->assertEquals($groupBy($keyGen, $testCase), $correctAnswer);

        // Test an object keygen
        $testCase = [['foo' => 'bar', 'value' => 1], ['foo' => 'bar', 'value' => 2], ['foo' => 'baz', 'value' => 3]];
        $correctAnswer = ['bar' => [['foo' => 'bar', 'value' => 1], ['foo' => 'bar', 'value' => 2]], 'baz' => [['foo' => 'baz', 'value' => 3]]];

        $this->assertEquals($groupBy(ArrayList::index('foo'), $testCase), $correctAnswer);
    }
}
