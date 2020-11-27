<?php

namespace Vector\Test\Lib\Stub;

use Vector\Core\Module;

class TestFunctions
{
    use Module;

    #[Curry]
    protected static function plusTwo($a)
    {
        return $a + 2;
    }

    #[Curry]
    protected static function timesTwo($a)
    {
        return $a * 2;
    }

    #[Curry]
    protected static function returnsTrue($a)
    {
        return true;
    }

    #[Curry]
    protected static function invertsBool($a)
    {
        return ! $a;
    }

    #[Curry]
    protected static function expectsNotNull($a)
    {
        return $a !== null;
    }
}
