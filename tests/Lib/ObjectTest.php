<?php

namespace Vector\Test\Lib;

use Vector\Lib\Object;
use Vector\Test\Control\Stub\TestObject;

/**
 * Class ObjectTest
 * @package Vector\Test\Lib
 */
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

    /**
     * Test can get property from object
     */
    public function testGetProp()
    {
        $obj = new \stdClass();
        $obj->test = 'works';

        self::assertEquals('works', Object::getProp('test', $obj));
    }

    /**
     * Test throws exception on undefined property
     * @expectedException \Vector\Core\Exception\UndefinedPropertyException
     */
    public function testGetPropThrows()
    {
        $obj = new \stdClass();
        $obj->test = 'works';

        Object::getProp('bad', $obj);
    }

    /**
     * Test throws exception on undefined or null property
     * @expectedException \Vector\Core\Exception\UndefinedPropertyException
     */
    public function testGetPropThrowsNullValue()
    {
        $obj = new \stdClass();
        $obj->test = null;

        Object::getProp('test', $obj);
    }

    /**
     * Test can set property on object
     */
    public function testSetProp()
    {
        $obj = Object::setProp('test', 'works', new \stdClass());

        self::assertEquals('works', $obj->test);
    }

    /**
     * Test can invoke method on object
     */
    public function testInvokeMethod()
    {
        self::assertEquals('works', Object::invokeMethod('getValue', new TestObject()));
    }
}
