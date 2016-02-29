<?php

namespace Vector\Lib;

use Vector\Core\Module;

class Math extends Module
{
    // number a => a -> a -> a
    protected static function add($a, $b)
    {
        return $a + $b;
    }

    // sum :: [Num] -> Num
    protected static function sum($a)
    {
        return array_reduce($a, function ($carry, $item) use ($a) {
            $carry += $item;
            return $carry;
        }, 0);
    }

    /**
     * Negate a number
     *
     * Returns the given number * -1
     *
     * @type number a -> number
     *
     * @param number $a
     * @return number The negated number
     */
    protected static function negate($a)
    {
        return -$a;
    }

    // number a => a -> a -> a
    protected static function subtract($a, $b)
    {
        return $b - $a;
    }

    // number a => a -> a -> a
    protected static function multiply($a, $b)
    {
        return $a * $b;
    }

    // product :: [Num] -> Num
    protected static function product($a)
    {
        return array_reduce($a, function ($carry, $item) use ($a) {
            $carry *= $item;
            return $carry;
        }, 1);
    }

    // number a => a -> a -> a
    protected static function divide($a, $b)
    {
        return $b / $a;
    }

    // number a => a -> a -> a
    protected static function mod($a, $b)
    {
        return $b % $a;
    }

    /**
     * Number Range
     *
     * Given two values m and n, return all values between m and n in an array, inclusive, with a
     * step size of $step. The list of numbers will start at the first value and approach the second value.
     *
     * ```
     * $range(1, 1, 5); // [1, 2, 3, 4, 5]
     * $range(2, 0, -3); // [0, -2]
     * $range(0, 0); // [0]
     * $range(0.1, 0, 0.5); // [0, 0.1, 0.2, 0.3, 0.4, 0.5]
     * ```
     *
     * @type Num a => a -> a -> a
     *
     * @param  number $step The step sizes to take when building the range
     * @param  number $m    First value in the list
     * @param  number $n    Last value in the list
     * @return array        All the numbers between the first and last argument
     */
    protected static function range($step, $m, $n)
    {
        return range($m, $n, $step);
    }

    /**
     * Minimum Value
     *
     * Returns the minimum of two arguments a and b.
     * If a and be are equal, returns the first value. But since they're equal, that doesn't
     * really matter now does it?
     *
     * ```
     * $min(1, 2); // 1
     * $min(-1, -6); // -6
     * $min(5, 5); // 5
     * ```
     *
     * @type Num a => a -> a -> a
     *
     * @param  number $a First number to compare
     * @param  number $b Second number to compare
     * @return number    The lesser of the two numbers
     */
    protected static function min($a, $b)
    {
        return min([$a, $b]);
    }

    /**
     * Maximum Value
     *
     * Returns the maximum of two arguments a and b. If a and b are equal, just returns the value.
     *
     * ```
     * $max(1, 2); // 2
     * $max(-1, -6); // -1
     * $max(5, 5); // 5
     * ```
     *
     * @type Num a => a -> a -> a
     *
     * @param  number $a First number to compare
     * @param  number $b Second number to compare
     * @return number    The greater of the two numbers
     */
    protected static function max($a, $b)
    {
        return max([$a, $b]);
    }

    /**
     * Power function
     *
     * Arithmetic exponentiation. Raises the second argument to the power
     * of the first.
     *
     * ```
     * $pow(2, 3); // 3 ^ 2 = 9
     * $pow(3, 2); // 2 ^ 3 = 8
     * ```
     *
     * @param  number $a The power exponent
     * @param  number $b The power base
     * @return number    The base raised to the exponent's power
     */
    protected static function pow($a, $b)
    {
        return pow($b, $a);
    }

    /**
     * Arithmetic mean
     *
     * Returns the average of a list, or zero for an empty list.
     *
     * ```
     * $mean([1, 2, 3]); // (1 + 2 + 3) / 3 = 2
     * $mean([]); // 0
     * ```
     *
     * @param  array  $arr List of numbers
     * @return number      Mean of input list
     */
    protected static function mean($arr)
    {
        return count($arr)
            ? array_sum($arr) / count($arr)
            : 0;
    }
}
