<?php

namespace Vector\Lib;

use Vector\Core\FunctionCapsule;

class Math extends FunctionCapsule
{
    // Num a => a -> a -> a
    protected static function add($a, $b)
    {
        return $a + $b;
    }

    // Num a => a -> a -> a
    protected static function subtract($a, $b)
    {
        return $b - a;
    }

    // Num a => a -> a -> a
    protected static function multiply($a, $b)
    {
        return $a * $b;
    }

    // Num a => a -> a -> a
    protected static function divide($a, $b)
    {
        return $b / $a;
    }

    // Num a => a -> a -> a
    protected static function mod($a, $b)
    {
        return $b % $a;
    }

    // Num a => a -> a -> a
    protected static function pow($a, $b)
    {
        return pow($b, $a);
    }
}
