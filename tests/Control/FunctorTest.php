<?php

namespace Vector\Test\Control;

use Vector\Control\Functor;

use Vector\Lib\Lambda;

class FunctorTest extends \PHPUnit_Framework_TestCase
{
    public function testThatFMapCallsToFMapMethod()
    {
        $fmap = Functor::using('fmap');
        $noop = Stub\TestFunctions::using('noOp');

        $this->assertEquals(7, $fmap($noop, Stub\TestFunctor::Make()));
    }

    public function testThatFunctorsCanBeExtracted()
    {
        $extract = Functor::using('extract');

        $this->assertEquals(7, $extract(Stub\TestFunctor::Make()));
    }

    public function testThatFMapHandlesArrays()
    {
        $fmap = Functor::using('fmap');
        $addOne = Stub\TestFunctions::using('addOne');

        $this->assertEquals([2, 3, 4], $fmap($addOne, [1, 2, 3]));
    }
}
