<?php

namespace Vector\Lib;

use Vector\Core\FunctionCapsule;

class Object extends FunctionCapsule
{
    // Int -> Obj a -> a -> Obj a
    protected static function set($key, $obj, $val)
    {
        $obj->$key = $val;
        return $obj;
    }
}
