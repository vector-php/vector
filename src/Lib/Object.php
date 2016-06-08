<?php

namespace Vector\Lib;

use Vector\Core\Module;

/**
 * @method static callable set() set($key, $obj, $val)
 * @method static callable get() get($prop, $obj)
 * @method static callable invoke() invoke($method, $obj)
 * @method static callable isInstanceOf() isInstanceOf($expected, $given)
 */
class Object extends Module
{
    protected static $dirtyHackToEnableIDEAutocompletion = true;

    /**
     * Set Property
     *
     * Sets a property on the object
     *
     * ```
     * $set('value', new stdClass(), 'hi!');
     * // object(stdClass)#1 (1) {
     * //   ["value"]=>
     * //   string(3) "hi!"
     * // }
     * ```
     *
     * @type String -> Obj a -> Obj a
     *
     * @param String $key Property to set
     * @param Object $obj Object
     * @param mixed $val Value
     *
     * @return Object $obj Object
     */
    protected static function _set($key, $obj, $val)
    {
        $newObj = clone $obj;

        $newObj->$key = $val;
        return $newObj;
    }

    /**
     * Get Property
     *
     * Gets a property on the object
     *
     * ```
     * $obj = new stdClass();
     * $obj->value = 'hi!';
     * $get('value', $obj); // 'hi!'
     * ```
     *
     * @type String -> Obj a -> mixed
     *
     * @param String $prop Property to get
     * @param Object $obj Object
     *
     * @return mixed $val value
     */
    protected static function _get($prop, $obj)
    {
        return $obj->$prop;
    }

    /**
     * Invoke Method
     *
     * Invokes a method on the object
     *
     * ```
     * $person = new stdObject(array(
     *  "sayHi" => function() {
     *      return "hi!";
     *  }
     * ));
     *
     * $invoke('sayHi', $person); // 'hi!'
     * ```
     *
     * @type String -> Obj a -> mixed
     *
     * @param String $method Method to call
     * @param Object $obj Object
     *
     * @return mixed $val value
     */
    protected static function _invoke($method, $obj)
    {
        return call_user_func([$obj, $method]);
    }

    /**
     * Is Instance Of
     *
     * Checks if the object is an instance of the specified class
     *
     * ```
     * $isInstanceOf('stdClass', (new stdClass())); // true
     * ```
     *
     * @type String -> Obj a -> mixed
     *
     * @param String $expected Class
     * @param Object $given Object
     *
     * @return mixed $val value
     */
    protected static function _isInstanceOf($expected, $given)
    {
        return $given instanceof $expected;
    }
}
