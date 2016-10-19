<?php

namespace Vector\Test\Data;

use Vector\Data\Constant;
use Vector\Control\Functor;
use Vector\Test\Data\Generic\FunctorLaws;

/**
 * Class ConstantTest
 * @package Vector\Test\Data
 */
class ConstantTest extends FunctorLaws
{
    public function setUp()
    {
        /**
         * Used for FunctorLaws
         */
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

    /**
     * Tests identity application
     */
    public function testFunctorApply()
    {
        $identityMultiplyBy2 = Constant::constant(function ($value) {
            return $value * 2;
        });

        $mapped = $identityMultiplyBy2->apply(Constant::constant(7));

        $this->assertEquals(Constant::constant(function ($value) {
            return $value * 2;
        }), $mapped);
    }

    /**
     * Tests pure constant construction
     */
    public function testFunctorPure()
    {
        $this->assertEquals(Constant::constant(7), Constant::pure(7));
    }

    /**
     * Tests bind for constant
     */
    public function testFunctorBind()
    {
        $multiplyBy2 = function ($value) {
            return $value * 2;
        };

        $constant = Constant::constant(7);

        $bound = $constant->bind($multiplyBy2);

        $this->assertEquals(Constant::constant(7), $bound);
    }
}
