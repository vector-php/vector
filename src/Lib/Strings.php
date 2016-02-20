<?php

namespace Vector\Lib;

use Vector\Core\FunctionCapsule;

class Strings extends FunctionCapsule
{
    // String -> String -> String
    protected static function concat($addition, $original)
    {
        return $original . $addition;
    }

    protected static function split($on, $string)
    {
        return explode($on, $string);
    }

    protected static function startsWith($subStr, $str)
    {
        return substr($str, 0, strlen($subStr)) === $subStr;
    }

    protected static function toLowercase($str)
    {
        return strtolower($str);
    }

    protected static function join($on, $string)
    {
        return implode($on, $string);
    }
}
