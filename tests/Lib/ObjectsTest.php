<?php

namespace Vector\Test\Lib;

use stdClass;
use PHPUnit\Framework\TestCase;
use Vector\Core\Exception\UndefinedPropertyException;
use Vector\Lib\Objects;
use Vector\Test\Control\Stub\TestObject;

/**
 * Class ObjectTest
 * @package Vector\Test\Lib
 */
class ObjectsTest extends TestCase
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
     */
    public function testGetPropThrows()
    {
        $this->expectException(UndefinedPropertyException::class);
        $obj = new \stdClass();
        $obj->test = 'works';

        Objects::getProp('bad', $obj);
    }

    /**
     * Test throws exception on undefined or null property
     */
    public function testGetPropThrowsNullValue()
    {
        $this->expectException(UndefinedPropertyException::class);

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
