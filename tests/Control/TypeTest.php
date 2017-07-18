<?php

namespace Vector\Test\Control;

use PHPUnit\Framework\TestCase;
use Vector\Control\Type;

/**
 * Class TypeTest
 * @package Vector\Test\Control
 */
class TypeTest extends TestCase
{
    /**
     * @method static bool string() string($value) check if value is a string
     * @method static bool int() int($value) check if value is an int
     * @method static bool number() number($value) check if value is a number
     * @method static bool float() float($value) check if value is a float
     * @method static bool bool() bool($value) check if value is a bool
     * @method static bool object() object($value) check if value is an object
     * @method static bool array() array($value) check if value is an array
     * @method static bool null() null($value) check if value is null
     */

    public function testString()
    {
        $this->assertTrue(Type::string('string'));
        $this->assertFalse(Type::string(null));
    }

    public function testInt()
    {
        $this->assertTrue(Type::int(1));
        $this->assertFalse(Type::int(null));
    }

    public function testNumber()
    {
        $this->assertTrue(Type::number(1));
        $this->assertFalse(Type::number(null));
    }

    public function testFloat()
    {
        $this->assertTrue(Type::float(1.0));
        $this->assertFalse(Type::float(null));
    }

    public function testBool()
    {
        $this->assertTrue(Type::bool(true));
        $this->assertFalse(Type::bool(null));
    }

    public function testObject()
    {
        $this->assertTrue(Type::object(new \stdClass()));
        $this->assertFalse(Type::object(null));
    }

    public function testArray()
    {
        $this->assertTrue(Type::array([1, 2, 3]));
        $this->assertFalse(Type::array(null));
    }

    public function testNull()
    {
        $this->assertTrue(Type::null(null));
        $this->assertFalse(Type::null(1));
    }
}
