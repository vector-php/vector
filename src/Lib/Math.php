<?php

namespace Vector\Lib;

use Vector\Core\Module;

class Math extends Module
{
    // Num a => a -> a -> a
    protected static function add($a, $b)
    {
        return $a + $b;
    }

    // Num a => a -> a -> a
    protected static function subtract($a, $b)
    {
        return $b - $a;
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

    /**
     * Power function
     *
     * Arithmetic exponentionation. Raises the second argument to the power
     * of the first.
     *
     * ```
     * $pow(2, 3); // 3 ^ 2 = 9
     * $pow(3, 2); // 2 ^ 3 = 8
     * ```
     *
     * @param  Num $a The power exponent
     * @param  Num $b The power base
     * @return Num    The base raised to the exponent's power
     */
    protected static function pow($a, $b)
    {
        return pow($b, $a);
    }

    /**
     * Arithemtic mean
     *
     * Returns the average of a list, or zero for an empty list.
     *
     * ```
     * $mean([1, 2, 3]); // (1 + 2 + 3) / 3 = 2
     * $mean([]); // 0
     * ```
     *
     * @param  [Num] $arr List of numbers
     * @return Num        Mean of input list
     */
    protected static function mean($arr)
    {
        return count($arr)
            ? array_sum($arr) / count($arr)
            : 0;
    }
}
