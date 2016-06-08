<?php

namespace Vector\Test\Lib;

use Vector\Lib\Lambda;

class LambdaTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test that compose works - compose goes back to front
     */
    public function testCompose()
    {
        $compose = Lambda::using('compose');
        list($timesTwo, $plusTwo) = Stub\TestFunctions::using('timesTwo', 'plusTwo');

        $composeSingle = $compose($plusTwo);
        $composeDouble = $compose($timesTwo, $plusTwo);

        $this->assertInstanceOf('\\Closure', $composeSingle);
        $this->assertInstanceOf('\\Closure', $composeDouble);

        $this->assertEquals($composeSingle(0), 2);
        $this->assertEquals($composeDouble(2), 8);
    }

    /**
     * Test any edge cases that might pop up in Compose - things
     * like returning null values
     */
    public function testComposeEdgeCases()
    {
        $compose = Lambda::using('compose');
        list($returnsTrue, $invertsBool, $expectsNotNull) = Stub\TestFunctions::using('returnsTrue', 'invertsBool', 'expectsNotNull');

        $shouldBeFalse = $compose($invertsBool, $returnsTrue);
        $shouldBeTrue = $compose($invertsBool, $invertsBool, $returnsTrue);

        $this->assertEquals(false, $shouldBeFalse(null));
        $this->assertEquals(true, $shouldBeTrue(null));

        $shouldBeNull = $compose($invertsBool, $expectsNotNull);

        $this->assertEquals(false, $shouldBeNull('foo'));
        $this->assertEquals(true, $shouldBeNull(null));
    }

    /**
     * Test that pipe works - pipe goes front to back
     */
    public function testPipe()
    {
        $pipe = Lambda::using('pipe');
        list($timesTwo, $plusTwo) = Stub\TestFunctions::using('timesTwo', 'plusTwo');

        $pipeSingle = $pipe($plusTwo);
        $pipeDouble = $pipe($timesTwo, $plusTwo);

        $this->assertInstanceOf('\\Closure', $pipeSingle);
        $this->assertInstanceOf('\\Closure', $pipeDouble);

        $this->assertEquals($pipeSingle(0), 2);
        $this->assertEquals($pipeDouble(2), 6);
    }

    /**
     * Test the constant function
     */
    public function testK()
    {
        $k = Lambda::using('k');

        $constant = $k(2);

        $this->assertEquals(2, $constant(7));
        $this->assertEquals(2, $constant(1, 2, 3));
    }

    /**
     * Test the identity function
     */
    public function testId()
    {
        $id = Lambda::using('id');

        $this->assertEquals(4, $id(4));
        $this->assertEquals('foo', $id('foo'));
    }
}
