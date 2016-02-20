<?php

namespace Vector\Lib;

use Vector\Core\FunctionCapsule;

class Object extends FunctionCapsule
{
    // Int -> Obj a -> a -> Obj a
    protected static function set($key, $obj, $val)
    {
        $newObj = clone $obj;

        $newObj->$key = $val;
        return $newObj;
    }

    protected static function get($prop, $obj)
    {
        return $obj->$prop;
    }

    protected static function invoke($method, $obj)
    {
        return call_user_func([$obj, $method]);
    }

    protected static function isInstanceOf($expected, $given)
    {
        return $given instanceof $expected;
    }
}
