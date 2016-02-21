<?php

namespace Vector\Test\Control\Stub;

use Vector\Core\Module;

class TestFunctions extends Module
{
    protected static function noOp($a)
    {
        return $a;
    }

    protected static function addOne($a)
    {
        return $a + 1;
    }
}
