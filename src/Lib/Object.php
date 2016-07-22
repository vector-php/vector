<?php

namespace Vector\Lib;

use Vector\Core\Module;

/**
 * @method static callable setValue() set($key, $obj, $val)
 * @method static callable getValue() get($prop, $obj)
 * @method static callable invokeMethod() invoke($method, $obj)
 * @method static callable isInstanceOf() isInstanceOf($expected, $given)
 */
class Object extends Module
{
    /**
     * Set Property
     *
     * Sets a property on the object
     *
     * @example
     * Object::setValue('value', new stdClass(), 'hi!');
     * // object(stdClass)#1 (1) {
     * //   ["value"]=>
     * //   string(3) "hi!"
     * // }
     *
     * @type String -> a -> Obj a -> Obj a
     *
     * @param  String $key Property to set
     * @param  mixed  $val Value
     * @param  Object $obj Object
     * @return Object $obj Object
     */
    protected static function __setProp($key, $val, $obj)
    {
        $newObj = clone $obj;

        $newObj->$key = $val;
        return $newObj;
    }

    protected static function __assign($props, $objOriginal)
    {
        $obj = clone $objOriginal;

        return ArrayList::foldl(function($obj, $setter) { return $setter($obj); }, $obj, ArrayList::mapIndexed(Lambda::flip(self::setProp()), $props));
    }

    /**
     * Get Property
     *
     * Gets a property on the object
     *
     * @example
     * $obj = new stdClass();
     * $obj->value = 'hi!';
     * Object::getValue('value', $obj); // 'hi!'
     *
     * @type String -> Obj a -> mixed
     *
     * @param String $prop Property to get
     * @param Object $obj Object
     * @return mixed $val value
     */
    protected static function __getProp($prop, $obj)
    {
        return $obj->$prop;
    }

    /**
     * Invoke Method
     *
     * Invokes a method on the object
     *
     * @example
     * $person = new stdObject(array(
     *  "sayHi" => function() {
     *      return "hi!";
     *  }
     * ));
     * Object::invokeMethod('sayHi', $person); // 'hi!'
     *
     * @type String -> Obj a -> mixed
     *
     * @param String $method Method to call
     * @param Object $obj Object
     * @return mixed $val value
     */
    protected static function __invokeMethod($method, $obj)
    {
        return call_user_func([$obj, $method]);
    }

    /**
     * Is Instance Of
     *
     * Checks if the object is an instance of the specified class
     *
     * @example
     * Object::isInstanceOf('stdClass', (new stdClass())); // true
     *
     * @type String -> Obj a -> mixed
     *
     * @param String $expected Class
     * @param Object $given Object
     * @return mixed $val value
     */
    protected static function __isInstanceOf($expected, $given)
    {
        return $given instanceof $expected;
    }
}
