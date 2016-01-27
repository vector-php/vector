<?php

namespace Vector\Test\Core\Stub;

use Vector\Core\FunctionCapsule;

class TestFunctions extends FunctionCapsule
{
    protected static function noArgFunction()
    {
        return true;
    }
    
    protected static function oneArgFunction($a)
    {
        return true;
    }
    
    protected static function twoArgFunction($a, $b)
    {
        return true;
    }
    
    protected static function variadicFunction(...$a)
    {
        return $a;
    }
    
    protected static function complexVariadicFunction($a, ...$b)
    {
        return $b;
    }
}
