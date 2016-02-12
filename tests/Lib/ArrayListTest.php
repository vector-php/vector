<?php

namespace Vector\Test\Lib;

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
     * @covers Vector\Lib\ArrayList::head
     */
    public function testHeadReturnsFirstElement()
    {
        $head = ArrayList::Using('head');

        $this->assertEquals($head($this->testCase), 0);
    }

    /**
     * Test that tail returns the rest of a list sans first element
     * @covers Vector\Lib\ArrayList::tail
     */
    public function testTailReturnsAllButFirstElement()
    {
        $tail = ArrayList::Using('tail');

        $this->assertEquals($tail($this->testCase), [1, 2, 3]);
    }

    /**
     * Test that init returns the first chunk of an array
     * @covers Vector\Lib\ArrayList::init
     */
    public function testInitReturnsAllButLastElement()
    {
        $init = ArrayList::Using('init');

        $this->assertEquals($init($this->testCase), [0, 1, 2]);
    }

    /**
     * Test that last returns the last element of a list
     * @covers Vector\Lib\ArrayList::last
     */
    public function testLastReturnsLastElement()
    {
        $last = ArrayList::Using('last');

        $this->assertEquals($last($this->testCase), 3);
    }

    /**
     * Test that length returns the length of a list
     * @covers Vector\Lib\ArrayList::length
     */
    public function testLengthReturnsLength()
    {
        $length = ArrayList::Using('length');

        $this->assertEquals($length($this->testCase), 4);
    }

    /**
     * Test that index returns the element of a list at the given index
     * @covers Vector\Lib\ArrayList::index
     */
    public function testIndexReturnsElementAtIndex()
    {
        $index = ArrayList::Using('index');

        $this->assertEquals($index(2, $this->testCase), 2);
    }

    /**
     * Test that set properly sets the value of an array at the index in an
     * immutable way
     * @covers Vector\Lib\ArrayList::set
     */
    public function testSetSetsArrayValueAtIndex()
    {
        $set = ArrayList::Using('set');

        $this->assertEquals($set(2, $this->testCase, 0), [0, 1, 0, 3]);
        $this->assertEquals($this->testCase, [0, 1, 2, 3]);
    }
}
