<?php

namespace Vector\Test\Lib\Stub;

use Vector\Core\Module;

class TestFunctions extends Module
{
    protected static function plusTwo($a)
    {
        return $a + 2;
    }

    protected static function timesTwo($a)
    {
        return $a * 2;
    }

    protected static function returnsTrue($a)
    {
        return true;
    }

    protected static function invertsBool($a)
    {
        return !$a;
    }

    protected static function expectsNotNull($a)
    {
        return $a !== null;
    }
}
