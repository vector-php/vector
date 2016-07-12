<?php

namespace Vector\Test\Control\Stub;

use Vector\Core\Module;

class TestFunctions extends Module
{
    protected static function __noOp($a)
    {
        return $a;
    }

    protected static function __addOne($a)
    {
        return $a + 1;
    }
}
