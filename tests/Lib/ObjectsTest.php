<?php

namespace Vector\Test\Lib;

use stdClass;
use Vector\Lib\Objects;
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
        $isInstanceOf = Objects::using('isInstanceOf');

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

        self::assertEquals('works', Objects::getProp('test', $obj));
    }

    /**
     * Test throws exception on undefined property
     * @expectedException \Vector\Core\Exception\UndefinedPropertyException
     */
    public function testGetPropThrows()
    {
        $obj = new \stdClass();
        $obj->test = 'works';

        Objects::getProp('bad', $obj);
    }

    /**
     * Test throws exception on undefined or null property
     * @expectedException \Vector\Core\Exception\UndefinedPropertyException
     */
    public function testGetPropThrowsNullValue()
    {
        $obj = new \stdClass();
        $obj->test = null;

        Objects::getProp('test', $obj);
    }

    /**
     * Test can set property on object
     */
    public function testSetProp()
    {
        $obj = Objects::setProp('test', 'works', new \stdClass());

        self::assertEquals('works', $obj->test);
    }

    /**
     * Test can invoke method on object
     */
    public function testInvokeMethod()
    {
        self::assertEquals('works', Objects::invokeMethod('getValue', new TestObject()));
    }

    /**
     * Test can assign
     */
    public function testAssign()
    {
        $object = new stdClass();
        $object->a = 'a';
        $object->b = 'b';

        $assigned = Objects::assign(['a' => 0, 'b' => 1], $object);

        $shouldBe = new stdClass();
        $shouldBe->a = 0;
        $shouldBe->b = 1;

        self::assertEquals($shouldBe, $assigned);
    }
}
