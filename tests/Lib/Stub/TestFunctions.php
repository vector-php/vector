<?php

namespace Vector\Test\Lib\Stub;

use Vector\Core\FunctionCapsule;

class TestFunctions extends FunctionCapsule
{
    protected static function plusTwo($a)
    {
        return $a + 2;
    }

    protected static function timesTwo($a)
    {
        return $a * 2;
    }
}
