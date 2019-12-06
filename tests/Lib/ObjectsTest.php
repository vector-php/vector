<?php

namespace Vector\Test\Lib;

use PHPUnit\Framework\TestCase;
use Vector\Core\Exception\UndefinedPropertyException;
use Vector\Lib\Objects;
use Vector\Test\Control\Stub\TestObject;
use stdClass;

class ObjectsTest extends TestCase
{
    /** @test */
    function is_instance_of()
    {
        $isInstanceOf = Objects::using('isInstanceOf');

        $this->assertTrue($isInstanceOf(stdClass::class, new stdClass));
        $this->assertFalse($isInstanceOf('nope', new stdClass));
    }

    /** @test */
    function get_prop()
    {
        $obj = new stdClass;
        $obj->test = 'works';

        self::assertEquals('works', Objects::getProp('test', $obj));
    }

    /** @test */
    function get_prop_throws_on_undefined()
    {
        $this->expectException(UndefinedPropertyException::class);
        $obj = new stdClass;
        $obj->test = 'works';

        Objects::getProp('bad', $obj);
    }

    /** @test */
    function get_prop_throws_null_value()
    {
        $this->expectException(UndefinedPropertyException::class);

        $obj = new stdClass;
        $obj->test = null;

        Objects::getProp('test', $obj);
    }

    /** @test */
    function set_prop()
    {
        $obj = Objects::setProp('test', 'works', new stdClass);

        self::assertEquals('works', $obj->test);
    }

    /** @test */
    function invoke_method()
    {
        self::assertEquals('works', Objects::invokeMethod('getValue', new TestObject));
    }

    /** @test */
    function assign()
    {
        $object = new stdClass;
        $object->a = 'a';
        $object->b = 'b';

        $assigned = Objects::assign(['a' => 0, 'b' => 1], $object);

        $shouldBe = new stdClass;
        $shouldBe->a = 0;
        $shouldBe->b = 1;

        self::assertEquals($shouldBe, $assigned);
    }
}
