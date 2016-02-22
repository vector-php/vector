<?php

namespace Vector\Test\Lib;

use Vector\Core\Exception\EmptyListException;
use Vector\Lib\ArrayList;

class ArrayListTest extends \PHPUnit_Framework_TestCase
{
    protected $testCase;

    protected function setUp()
    {
        $this->testCase = [0, 1, 2, 3];
    }

    /**
     * Tests that head returns the first element of a list
     */
    public function testHeadReturnsFirstElement()
    {
        $head = ArrayList::Using('head');

        $this->assertEquals($head($this->testCase), 0);
    }

    /**
     * Expect that an EmptyListException is thrown for head on empty lists
     */
    public function testHeadUndefinedOnEmptyList()
    {
        $head = ArrayList::Using('head');
        $this->expectException(EmptyListException::class);

        $head([]); // Throws Exception
    }

    /**
     * Test that tail returns the rest of a list sans first element
     */
    public function testTailReturnsAllButFirstElement()
    {
        $tail = ArrayList::Using('tail');

        $this->assertEquals($tail($this->testCase), [1, 2, 3]);
    }

    /**
     * Test that init returns the first chunk of an array
     */
    public function testInitReturnsAllButLastElement()
    {
        $init = ArrayList::Using('init');

        $this->assertEquals($init($this->testCase), [0, 1, 2]);
    }

    /**
     * Test that last returns the last element of a list
     */
    public function testLastReturnsLastElement()
    {
        $last = ArrayList::Using('last');

        $this->assertEquals($last($this->testCase), 3);
    }

    /**
     * Expect that an EmptyListException is thrown for last on empty lists
     */
    public function testLastUndefinedOnEmptyList()
    {
        $last = ArrayList::Using('last');
        $this->expectException(EmptyListException::class);

        $last([]); // Throws Exception
    }

    /**
     * Test that length returns the length of a list
     */
    public function testLengthReturnsLength()
    {
        $length = ArrayList::Using('length');

        $this->assertEquals($length($this->testCase), 4);
    }

    /**
     * Test that index returns the element of a list at the given index
     */
    public function testIndexReturnsElementAtIndex()
    {
        $index = ArrayList::Using('index');

        $this->assertEquals($index(2, $this->testCase), 2);
    }

    /**
     * Test that set properly sets the value of an array at the index in an
     * immutable way
     */
    public function testSetSetsArrayValueAtIndex()
    {
        $set = ArrayList::Using('set');

        $this->assertEquals($set(2, $this->testCase, 0), [0, 1, 0, 3]);
        $this->assertEquals($this->testCase, [0, 1, 2, 3]);
    }

    /**
     * Test that keys returns the keys of a key/value array
     */
    public function testKeysReturnsMapKeys()
    {
        $keys = ArrayList::using('keys');

        $this->assertEquals([0, 1, 2], $keys([5, 5, 5]));
        $this->assertEquals(['foo', 'bar', 'baz'], $keys(['foo' => 1, 'bar' => 2, 'baz' => 3]));
    }

    /**
     * Test that values returns key/value array values
     */
    public function testValuesReturnsMapValues()
    {
        $values = ArrayList::using('values');

        $this->assertEquals([1, 2, 3], $values([1, 2, 3]));
        $this->assertEquals([1, 2, 3], $values(['foo' => 1, 'bar' => 2, 'baz' => 3]));
    }

    /**
     * Test that the filter function correctly filters an array of data
     */
    public function testFilterFunctionFiltersArrays()
    {
        $filter = ArrayList::using('filter');

        $id = function($a) { return true; };
        $gt = function($b) { return $b >= 2; };

        $this->assertEquals([0, 1, 2, 3], $filter($id, $this->testCase));
        $this->assertEquals([2 => 2, 3 => 3], $filter($gt, $this->testCase));
    }
}
