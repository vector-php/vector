<?php

namespace Vector\Test\Control\Stub;

use Vector\Control\Extractable;

/**
 * Class TestParentType
 * @package Vector\Test\Control\Stub
 */
abstract class TestParentType implements Extractable
{
    public static function typeA($value)
    {
        return new TestChildTypeA($value);
    }

    public static function typeB($value)
    {
        return new TestChildTypeB($value);
    }
}
