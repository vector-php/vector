<?php

namespace Vector\Test\Control\Stub;

use Vector\Core\FunctionCapsule;

class TestFunctions extends FunctionCapsule
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
