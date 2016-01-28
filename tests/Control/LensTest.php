<?php

namespace Vector\Test\Core;

use Vector\Control\Lens;

class LensTest extends \PHPUnit_Framework_TestCase
{
    public function testLensesCanBeCreated()
    {
        list($indexLens, $propLens) = Lens::using('indexLens', 'propLens');

        $testIndex = $indexLens(0);
        $testProp  = $propLens('a');

        $this->assertInstanceOf('\\Closure', $testIndex);
        $this->assertInstanceOf('\\Closure', $testProp);
    }

    public function testViewThroughLens()
    {

    }

    public function testSetThroughLens()
    {

    }

    public function testSetDoesNotMutateData()
    {

    }

    public function testMapOverLens()
    {

    }

    public function testLensComposition()
    {

    }
}