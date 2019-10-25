<?php

namespace Vector\Test\Control\Stub;

use Vector\Core\Module;
use Vector\Typeclass\FunctorInterface;
use Vector\Typeclass\simpleFunctorDefault;

abstract class TestMultipleTypeConstructor extends Module implements FunctorInterface
{
    use simpleFunctorDefault;

    public static function __ints(int $a, int $b, int $c)
    {
        return new TestInts($a, $b, $c);
    }

    public static function __intsAndString(int $a, int $b, string $str)
    {
        return new TestIntsAndString($a, $b, $str);
    }
}
