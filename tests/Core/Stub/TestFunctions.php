<?php

namespace Vector\Test\Core\Stub;

use Vector\Core\Module;
use Vector\Core\Curry;

class TestFunctions
{
    use Module;

    #[Curry]
    protected static function notAPureFunction()
    {
        return true;
    }

    #[Curry]
    protected static function noArgFunction()
    {
        return true;
    }

    #[Curry]
    protected static function oneArgFunction($a)
    {
        return true;
    }

    #[Curry]
    protected static function twoArgFunction($a, $b)
    {
        return true;
    }

    #[Curry]
    protected static function variadicFunction(...$a)
    {
        return $a;
    }

    #[Curry]
    protected static function complexVariadicFunction($a, ...$b)
    {
        return $b;
    }

    #[Curry]
    protected static function nonCurriedFunction($a, $b)
    {
        return true;
    }
}
