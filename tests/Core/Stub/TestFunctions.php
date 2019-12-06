<?php

namespace Vector\Test\Core\Stub;

use Vector\Core\Module;

class TestFunctions extends Module
{
    protected static array $doNotCurry = ['nonCurriedFunction'];

    protected static $memoize = true;

    public static function getFulfillmentCache()
    {
        return static::$fulfillmentCache;
    }

    protected static function __notAPureFunction()
    {
        return true;
    }

    protected static function __noArgFunction()
    {
        return true;
    }

    protected static function __oneArgFunction($a)
    {
        return true;
    }

    protected static function __twoArgFunction($a, $b)
    {
        return true;
    }

    protected static function __variadicFunction(...$a)
    {
        return $a;
    }

    protected static function __complexVariadicFunction($a, ...$b)
    {
        return $b;
    }

    protected static function __nonCurriedFunction($a, $b)
    {
        return true;
    }

    protected static function __memoizedFunction($a, $b, $c)
    {
        echo "I'm a side effect.";

        return $a + $b + $c;
    }
}
