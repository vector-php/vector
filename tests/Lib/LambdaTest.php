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
}
