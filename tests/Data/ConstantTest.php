<?php

namespace Vector\Test\Data;

use Vector\Data\Constant;
use Vector\Control\Functor;
use Vector\Lib\Lambda;

class ConstantTest extends Generic\GenericFunctorTestCase
{
    public function setUp()
    {
        $this->testCases = [
            Constant::constant(7)
        ];
    }

    /**
     * Test that constant functors are created properly from the static constructor
     */
    public function testConstantsCanBeConstructed()
    {
        $myConst = Constant::constant(7);

        $this->assertInstanceOf(Constant::class, $myConst);
    }

    /**
     * Tests that extraction off the functor works for interfacing with PHP land
     */
    public function testFunctorExtract()
    {
        $extract = Functor::using('extract');
        $myConst = Constant::constant(7);

        $this->assertEquals($extract($myConst), 7);
    }
}
