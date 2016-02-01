<?php

namespace Vector\Test\Control;

use Vector\Control\Functor;

use Vector\Lib\Lambda;

class FunctorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the $fmap function - It should call to the given container's FMap method
     * @covers Vector\Control\Functor::fmap
     */
    public function testThatFMapCallsToFMapMethod()
    {
        $fmap = Functor::using('fmap');
        $noop = Stub\TestFunctions::using('noOp');

        $this->assertEquals(7, $fmap($noop, Stub\TestFunctor::Make()));
    }

    /**
     * Tests the $extract function - It should call to a given container's Extract method
     * @covers Vector\Control\Functor::extract
     */
    public function testThatFunctorsCanBeExtracted()
    {
        $extract = Functor::using('extract');

        $this->assertEquals(7, $extract(Stub\TestFunctor::Make()));
    }

    /**
     * FMap should behave as if it were array_map when invoked on an array
     * @covers Vector\Control\Functor::fmap
     */
    public function testThatFMapHandlesArrays()
    {
        $fmap = Functor::using('fmap');
        $addOne = Stub\TestFunctions::using('addOne');

        $this->assertEquals([2, 3, 4], $fmap($addOne, [1, 2, 3]));
    }
}
