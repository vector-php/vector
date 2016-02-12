<?php

namespace Vector\Lib;

use Vector\Core\FunctionCapsule;

class ArrayList extends FunctionCapsule
{
    // [a] -> a
    protected static function head($list)
    {
        return $list[0];
    }

    // [a] -> [a]
    protected static function tail($list)
    {
        return array_slice($list, 1, count($list));
    }

    // [a] -> [a]
    protected static function init($list)
    {
        return array_slice($list, 0, count($list) - 1);
    }

    // [a] -> a
    protected static function last($list)
    {
        return $list[count($list) - 1];
    }

    // [a] -> Int
    protected static function length($list)
    {
        return count($list);
    }

    // Int -> [a] -> a
    protected static function index($i, $list)
    {
        return $list[$i];
    }

    // Int -> [a] -> a -> [a]
    protected static function set($key, $arr, $val)
    {
        $arr[$key] = $val;
        return $arr;
    }
}
