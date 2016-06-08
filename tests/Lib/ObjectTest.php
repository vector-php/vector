<?php

namespace Vector\Test\Lib;

use Vector\Lib\Object;

class ObjectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test that instanceOf works as intended
     */
    public function testIsInstanceOf()
    {
        $isInstanceOf = Object::using('isInstanceOf');

        $this->assertTrue($isInstanceOf(\stdClass::class, new \stdClass()));
        $this->assertFalse($isInstanceOf('nope', new \stdClass()));
    }
}
