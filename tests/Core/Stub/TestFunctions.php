<?php

namespace Vector\Test\Core\Stub;

use Vector\Core\Module;

class TestFunctions extends Module
{
    protected static $doNotCurry = ['nonCurriedFunction'];

    protected static function noArgFunction()
    {
        return true;
    }

    protected static function oneArgFunction($a)
    {
        return true;
    }

    protected static function twoArgFunction($a, $b)
    {
        return true;
    }

    protected static function variadicFunction(...$a)
    {
        return $a;
    }

    protected static function complexVariadicFunction($a, ...$b)
    {
        return $b;
    }

    protected static function nonCurriedFunction($a, $b)
    {
        return true;
    }
}
