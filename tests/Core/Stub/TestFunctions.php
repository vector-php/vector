<?php

namespace Vector\Test\Core\Stub;

use Vector\Core\Module;

class TestFunctions extends Module
{
    protected static $dirtyHackToEnableIDEAutocompletion = true;

    protected static $doNotCurry = ['nonCurriedFunction'];

    protected static $memoize = true;

    protected static function _noArgFunction()
    {
        return true;
    }

    protected static function _oneArgFunction($a)
    {
        return true;
    }

    protected static function _twoArgFunction($a, $b)
    {
        return true;
    }

    protected static function _variadicFunction(...$a)
    {
        return $a;
    }

    protected static function _complexVariadicFunction($a, ...$b)
    {
        return $b;
    }

    protected static function _nonCurriedFunction($a, $b)
    {
        return true;
    }

    protected static function _memoizedFunction($a, $b, $c)
    {
        echo "I'm a side effect.";

        return $a + $b + $c;
    }
}
