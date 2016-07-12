<?php

namespace Vector\Test\Lib\Stub;

use Vector\Core\Module;

class TestFunctions extends Module
{
    protected static function __plusTwo($a)
    {
        return $a + 2;
    }

    protected static function __timesTwo($a)
    {
        return $a * 2;
    }

    protected static function __returnsTrue($a)
    {
        return true;
    }

    protected static function __invertsBool($a)
    {
        return !$a;
    }

    protected static function __expectsNotNull($a)
    {
        return $a !== null;
    }
}
