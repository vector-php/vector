<?php

namespace Vector\Lib;

use Vector\Core\Module;

/**
 * @method static callable add(...$args)
 * @method static callable sum(...$args)
 * @method static callable negate(...$args)
 * @method static callable subtract(...$args)
 * @method static callable multiply(...$args)
 * @method static callable product(...$args)
 * @method static callable divide(...$args)
 * @method static callable mod(...$args)
 * @method static callable range(...$args)
 * @method static callable min(...$args)
 * @method static callable max(...$args)
 * @method static callable pow(...$args)
 * @method static callable mean(...$args)
 */
class Math extends Module
{
    /**
     * Arithmetic Addition
     *
     * Add two numbers together.
     *
     * @param number $a First number to add
     * @param number $b Second number to add
     * @return number
     *
     * @example
     * Math::add(-1, 2); // 1
     *
     * @example
     * Math::add(2, 2); // 4
     *
     * @type Number a => a -> a -> a
     *
     */
    protected static function __add($a, $b)
    {
        return $a + $b;
    }

    /**
     * Array Sum
     *
     * Add all the numbers of a list together and return their sum. If the given
     * list is empty, returns 0.
     *
     * @param array $a List of numbers to add
     * @return number    Sum of all the elements of the list
     *
     * @example
     * Math::sum([1, 2, 3]); // 6
     *
     * @example
     * Math::sum([]); // 0
     *
     * @type Number a => [a] -> a
     *
     */
    protected static function __sum($a)
    {
        return array_reduce($a, function ($carry, $item) use ($a) {
            $carry += $item;
            return $carry;
        }, 0);
    }

    /**
     * Negate a number.
     *
     * Returns a given number * -1.
     *
     * @param number $a Number to make negative
     * @return number    The negated number
     * @example
     * Math::negate(4); // -4
     *
     * @example
     * Math::negate(0); // 0
     *
     * @type Number a => a -> a
     *
     */
    protected static function __negate($a)
    {
        return -$a;
    }

    /**
     * Arithmetic Subtraction.
     *
     * Subtracts two numbers, with the first argument being subtracted from the second.
     *
     * @param number $a Number to subtract
     * @param number $b Number to subtract from
     * @return number    Subtraction of $b - $a
     * @example
     * Math::subtract(-1, 3); // 4
     *
     * @type Number a => a -> a -> a
     *
     * @example
     * Math::subtract(4, 9); // 5
     *
     */
    protected static function __subtract($a, $b)
    {
        return $b - $a;
    }

    /**
     * Arithmetic Multiplication
     *
     * Multiply two numbers together.
     *
     * @param number $a First number to multiply
     * @param number $b Second number to multiply
     * @return number    Multiplication of $a * $b
     * @example
     * Math::multiply(0, 4); // 0
     *
     * @type Number a => a -> a -> a
     *
     * @example
     * Math::multiply(2, 4); // 8
     *
     */
    protected static function __multiply($a, $b)
    {
        return $a * $b;
    }

    /**
     * Array Product
     *
     * Returns the product of a list of numbers, i.e. the result of multiplying
     * every element of a list together. Returns 1 for an empty list.
     *
     * @param array $a List of values to multiply
     * @return mixed    Product of every value in the list
     * @example
     * Math::product([2, 2, 3]); // 12
     *
     * @example
     * Math::product([]); // 1
     *
     * @type Number a => [a] -> a
     *
     */
    protected static function __product($a)
    {
        return empty($a)
            ? 0
            : array_reduce($a, function ($carry, $item) use ($a) {
                $carry *= $item;
                return $carry;
            }, 1);
    }

    /**
     * Arithmetic Division
     *
     * Divide two numbers, with the first argument being the divisor.
     *
     * @param number $a Denominator
     * @param number $b Numerator
     * @return float     Result of $b divided by $a
     * @example
     * Math::divide(4, 12); // 3
     *
     * @type Number a => a -> a -> a
     *
     * @example
     * Math::divide(2, 8); // 4
     *
     */
    protected static function __divide($a, $b)
    {
        return $b / $a;
    }

    /**
     * Modulus Operator
     *
     * Take the modulus of two integers, with the first argument being the divisor.
     * Returns the remainder of $b / $a.
     *
     * @param int $a Divisor
     * @param int $b Numerator
     * @return int    Remainder of $b / $a
     * @example
     * Math::mod(2, 5); // 1
     *
     * @example
     * Math::mod(5, 12); // 2
     *
     * @example
     * Math::mod(3, 3); // 0
     *
     * @type Int -> Int -> Int
     *
     */
    protected static function __mod($a, $b)
    {
        return $b % $a;
    }

    /**
     * Number Range
     *
     * Given two values m and n, return all values between m and n in an array, inclusive, with a
     * step size of $step. The list of numbers will start at the first value and approach the second value.
     *
     * @param number $step The step sizes to take when building the range
     * @param number $first First value in the list
     * @param number $last Last value in the list
     * @return array        All the numbers between the first and last argument
     * @example
     * Math::range(1, 1, 5); // [1, 2, 3, 4, 5]
     *
     * @example
     * Math::range(2, 0, -3); // [0, -2]
     *
     * @example
     * Math::range(0, 0, 0); // [0]
     *
     * @example
     * Math::range(0.1, 0, 0.5); // [0, 0.1, 0.2, 0.3, 0.4, 0.5]
     *
     * @type Number a => a -> a -> a
     *
     */
    protected static function __range($step, $first, $last)
    {
        return ($step + $first >= $last)
            ? [$first]
            : range($first, $last, $step);
    }

    /**
     * Minimum Value
     *
     * Returns the minimum of two arguments a and b.
     * If a and be are equal, returns the first value. But since they're equal, that doesn't
     * really matter now does it?
     *
     * @param number $a First number to compare
     * @param number $b Second number to compare
     * @return number    The lesser of the two numbers
     * @example
     * Math::min(1, 2); // 1
     *
     * @example
     * Math::min(-1, -6); // -6
     *
     * @example
     * Math::min(5, 5); // 5
     *
     * @type Number a => a -> a -> a
     *
     */
    protected static function __min($a, $b)
    {
        return min([$a, $b]);
    }

    /**
     * Maximum Value
     *
     * Returns the maximum of two arguments a and b. If a and b are equal, just returns the value.
     *
     * @param number $a First number to compare
     * @param number $b Second number to compare
     * @return number    The greater of the two numbers
     * @example
     * Math::max(1, 2); // 2
     *
     * @example
     * Math::max(-1, -6); // -1
     *
     * @example
     * Math::max(5, 5); // 5
     *
     * @type Number a => a -> a -> a
     *
     */
    protected static function __max($a, $b)
    {
        return max([$a, $b]);
    }

    /**
     * Power function
     *
     * Arithmetic exponentiation. Raises the second argument to the power
     * of the first.
     *
     * @param number $a The power exponent
     * @param number $b The power base
     * @return number    The base raised to the exponent's power
     * @example
     * Math::pow(3, 2); // 2 ^ 3 = 8
     *
     * @type Number a => a -> a -> a
     *
     * @example
     * Math::pow(2, 3); // 3 ^ 2 = 9
     *
     */
    protected static function __pow($a, $b)
    {
        return pow($b, $a);
    }

    /**
     * Arithmetic mean
     *
     * Returns the average of a list, or zero for an empty list.
     *
     * @param array $arr List of numbers
     * @return number      Mean of input list
     * @example
     * Math::mean([1, 2, 3]); // (1 + 2 + 3) / 3 = 2
     *
     * @example
     * Math::mean([]); // 0
     *
     * @type Number a => [a] -> a
     *
     */
    protected static function __mean($arr)
    {
        return count($arr)
            ? array_sum($arr) / count($arr)
            : 0;
    }
}
