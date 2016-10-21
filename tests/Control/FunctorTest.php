<?php

namespace Vector\Test\Control;

use Vector\Control\Functor;

/**
 * Class FunctorTest
 * @package Vector\Test\Control
 */
class FunctorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the $fmap function - It should call to the given container's FMap method
     */
    public function testThatFMapCallsToFMapMethod()
    {
        $fmap = Functor::using('fmap');
        $noop = Stub\TestFunctions::using('noOp');

        $this->assertEquals(7, $fmap($noop, Stub\TestFunctor::Make()));
    }

    /**
     * Tests the $extract function - It should call to a given container's Extract method
     */
    public function testThatFunctorsCanBeExtracted()
    {
        $extract = Functor::using('extract');

        $this->assertEquals(7, $extract(Stub\TestFunctor::Make()));
    }

    /**
     * FMap should behave as if it were array_map when invoked on an array
     */
    public function testThatFMapHandlesArrays()
    {
        $fmap = Functor::using('fmap');
        $addOne = Stub\TestFunctions::using('addOne');

        $this->assertEquals([2, 3, 4], $fmap($addOne, [1, 2, 3]));
    }

    /**
     * FMap should behave as if it were compose when invoked on a closure
     */
    public function testThatFmapHandlesClosures()
    {
        $fmap = Functor::using('fmap');

        $addOne = Stub\TestFunctions::using('addOne');
        $mulTwo = function ($a) {
            return $a * 2;
        };

        $fmappedFunction = $fmap($mulTwo, $addOne);

        $this->assertEquals($fmappedFunction(5), 12);
    }

    /**
     * FMap should behave as if it were map when invoked on a traversable
     */
    public function testThatFmapHandlesTraversable()
    {
        $fmap = Functor::using('fmap');

        $mulTwo = function ($a) {
            return $a * 2;
        };

        $this->assertEquals([2, 4], $fmap($mulTwo, new \ArrayIterator([1, 2])));
    }
}
