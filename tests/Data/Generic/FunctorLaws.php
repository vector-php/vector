<?php

namespace Vector\Test\Data\Generic;

use Vector\Data\Constant;
use Vector\Control\Functor;
use Vector\Lib\Lambda;

class FunctorLaws extends \PHPUnit_Framework_TestCase
{
    protected $testCases;

    /**
     * Tests the functor identity law, e.g. fmap id = id
     */
    public function testFunctorLawIdentity()
    {
        $id = Lambda::using('id');
        $fmap = Functor::using('fmap');
        $testFunctorList = $this->testCases;

        foreach ($testFunctorList as $testFunctor) {
            $this->assertEquals($fmap($id, $testFunctor), $testFunctor);
        }
    }

    /**
     * Tests the functor composition law, e.g. fmap (g . f) = fmap g . fmap f
     */
    public function testFunctorLawComposition()
    {
        $compose = Lambda::using('compose');
        $fmap = Functor::using('fmap');
        $testFunctorList = $this->testCases;

        $funcG = function($a) { return $a + 1; };
        $funcF = function($b) { return $b + 2; };

        foreach ($testFunctorList as $testFunctor) {
            $fmapCompose = $fmap($compose($funcG, $funcF), $testFunctor);
            $composeFmap = $compose($fmap($funcG), $fmap($funcF));

            $this->assertEquals($fmapCompose, $composeFmap($testFunctor));
        }
    }
}
