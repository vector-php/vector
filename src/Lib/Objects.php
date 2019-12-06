<?php

namespace Vector\Lib;

use Vector\Core\Exception\UndefinedPropertyException;
use Vector\Core\Module;

/**
 * @method static callable getProp(...$args)
 * @method static callable setProp(...$args)
 * @method static callable invokeMethod(...$args)
 * @method static callable isInstanceOf(...$args)
 * @method static callable assign(...$args)
 */
class Objects extends Module
{
    /**
     * Set Property
     *
     * Sets a property on the object
     *
     * @param String $key Property to set
     * @param mixed $val Value
     * @param Object $obj Object
     * @return Object $obj Object
     * @example
     * Object::setValue('value', new stdClass(), 'hi!');
     * // object(stdClass)#1 (1) {
     * //   ["value"]=>
     * //   string(3) "hi!"
     * // }
     *
     * @type String -> a -> Object a -> Object a
     *
     */
    protected static function __setProp($key, $val, $obj)
    {
        $newObj = clone $obj;

        /** @noinspection PhpVariableVariableInspection */
        $newObj->$key = $val;
        return $newObj;
    }

    /**
     * Assign Properties
     *
     * Set/Update properties on the object using a key/value array
     *
     * @param $props
     * @param $objOriginal
     * @return mixed
     * @example
     * Object::assign(['value' => 'hi!'], new stdClass);
     * // object(stdClass)#1 (1) {
     * //   ["value"]=>
     * //   string(3) "hi!"
     * // }
     *
     * @type array props -> Object objOriginal -> Object objUpdated
     *
     */
    protected static function __assign($props, $objOriginal)
    {
        $obj = clone $objOriginal;

        /** @noinspection PhpParamsInspection */
        return Arrays::reduce(
            function ($obj, $setter) {
                return $setter($obj);
            },
            $obj,
            Arrays::mapIndexed(Lambda::flip(self::setProp()), $props)
        );
    }

    /**
     * Get Property
     *
     * Gets a property on the object
     *
     * @param String $prop Property to get
     * @param Object $obj Object
     * @return mixed $val value
     * @throws UndefinedPropertyException
     * @example
     * $obj = new stdClass();
     * $obj->value = 'hi!';
     * Object::getValue('value', $obj); // 'hi!'
     *
     * @type String -> Object a -> a
     *
     */
    protected static function __getProp($prop, $obj)
    {
        if (! isset($obj->{$prop})) {
            throw new UndefinedPropertyException("'getProp' function tried to access undefined property '{$prop}'");
        }

        return $obj->{$prop};
    }

    /**
     * Invoke Method
     *
     * Invokes a method on the object
     *
     * @param String $method Method to call
     * @param Object $obj Object
     * @return mixed $val value
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
     * @param String $expected Class
     * @param Object $given Object
     * @return mixed $val value
     * @example
     * Object::isInstanceOf('stdClass', (new stdClass())); // true
     *
     * @type String -> Obj a -> mixed
     *
     */
    protected static function __isInstanceOf($expected, $given)
    {
        return $given instanceof $expected;
    }
}
