<?php

namespace Vector\Test\Data;

use Vector\Data\Constant;
use Vector\Control\Functor;
use Vector\Lib\Lambda;

class ConstantTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test that constant functors are created properly from the static constructor
     */
    public function testConstantsCanBeConstructed()
    {
        $myConst = Constant::constant(7);

        $this->assertInstanceOf(Constant::class, $myConst);
    }

    public function testFunctorLawIdentity()
    {
        $id = Lambda::using('id');
        $fmap = Functor::using('fmap');
        $myConst = Constant::constant(7);

        $this->assertEquals($fmap($id, $myConst), $myConst);
    }

    public function testFunctorLawComposition()
    {
        $compose = Lambda::using('compose');
        $fmap = Functor::using('fmap');
        $myConst = Constant::constant(7);

        $funcG = function($a) { return $a + 1; };
        $funcF = function($b) { return $b + 2; };

        $fmapCompose = $fmap($compose($funcG, $funcF), $myConst);
        $composeFmap = $compose($fmap($funcG), $fmap($funcF));

        $this->assertEquals($fmapCompose, $composeFmap($myConst));
    }

    public function testFunctorExtract()
    {
        $extract = Functor::using('extract');
        $myConst = Constant::constant(7);

        $this->assertEquals($extract($myConst), 7);
    }
}
