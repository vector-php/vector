<?php

namespace Vector\Test\Control\Stub;

use Vector\Control\Extractable;

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
