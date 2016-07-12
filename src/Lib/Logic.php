<?php

namespace Vector\Lib;

use Vector\Core\Module;

use Vector\Lib\ArrayList;

/**
 * @method static callable orCombinator() orCombinator($fs, $a)
 * @method static callable andCombinator() andCombinator($fs, $a)
 * @method static bool logicalOr() logicalOr($f, $g)
 * @method static bool logicalNot() logicalNot($a)
 * @method static bool logicalAnd() logicalAnd($a, $b)
 * @method static bool gt() gt($a, $b)
 * @method static bool gte() gte($a, $b)
 * @method static bool lt() lt($a, $b)
 * @method static bool lte() lte($a, $b)
 * @method static bool eq() eq($a, $b)
 * @method static bool eqStrict() eqStrict($a, $b)
 * @method static bool notEq() notEq($a, $b)
 * @method static bool notEqStrict() notEqStrict($a, $b)
 * @method static bool all() all($arr)
 * @method static bool any() any($arr)
 */
class Logic extends Module
{
    /**
     * Logical Or Combinator
     *
     * Given two functions f and g, combine them in such a way to produce a new
     * function h that returns true given f(x) OR g(x) returns true.
     *
     * ```
     * $funcF = function($x) { return $x >= 5; };
     * $funcG = function($x) { return $x == 0; };
     *
     * $combinator = $orCombinator([$funcF, $funcG]);
     *
     * $combinator(9); // True
     * $combinator(0); // True
     * $combinator(2); // False
     * ```
     *
     * @type [(a -> Bool)] -> a -> Bool
     *
     * @param array $fs array of functions to combine
     * @param mixed $a value to test
     * @return \Closure test for or using provided functions
     */
    protected static function __orCombinator(array $fs, $a)
    {
        return self::any(ArrayList::map(function ($c) use ($a) {
            return $c($a);
        }, $fs));
    }

    /**
     * Logical And Combinator
     *
     * Given two functions f and g, combine them in such a way to produce a new
     * function h that returns true given f(x) AND g(x) returns true.
     *
     * ```
     * $funcF = function($x) { return $x < 5; };
     * $funcG = function($x) { return $x > 0; };
     *
     * $combinator = $orCombinator([$funcF, $funcG]);
     *
     * $combinator(4); // True
     * $combinator(2); // True
     * $combinator(7); // False
     * ```
     *
     * @type [(a -> Bool)] -> a -> Bool
     *
     * @param array $fs array of functions to combine
     * @param mixed $a value to test
     * @return \Closure test for or using provided functions
     */
    protected static function __andCombinator(array $fs, $a)
    {
        return self::all(ArrayList::map(function ($c) use ($a) {
            return $c($a);
        }, $fs));
    }

    /**
     * Logical Or
     *
     * Returns true given $a OR $b returns true.
     *
     * ```
     * $logicalOr(true, false); // True
     * $logicalOr(false, false); // False
     * ```
     *
     * @type Bool -> Bool -> Bool
     *
     * @param  mixed $a First value
     * @param  mixed $b Second value
     * @return Bool Result of OR
     */
    protected static function __logicalOr($a, $b)
    {
        return $a || $b;
    }

    /**
     * Logical Not
     *
     * Returns true given $a is false.
     * Returns false given $a is true.
     *
     * ```
     * $logicalNot(true); // False
     * $logicalNot(false); // True
     * ```
     *
     * @type Bool -> Bool
     *
     * @param  mixed $a value
     * @return Bool Result of NOT
     */
    protected static function __logicalNot($a)
    {
        return !$a;
    }

    /**
     * Logical And
     *
     * Returns true given $a AND $b are true.
     *
     * ```
     * $logicalAnd(true, true); // True
     * $logicalAnd(true, false); // False
     * ```
     *
     * @type Bool -> Bool -> Bool
     *
     * @param  mixed $a First value
     * @param  mixed $b Second value
     * @return Bool Result of AND
     */
    protected static function __logicalAnd($a, $b)
    {
        return $a && $b;
    }

    /**
     * Greater Than
     *
     * Returns true given $b is greater than $a.
     *
     * ```
     * $gt(2, 1); // False
     * $gt(1, 2); // True
     * ```
     *
     * @type mixed -> mixed -> Bool
     *
     * @param  mixed $a Value
     * @param  mixed $b Value to test
     * @return Bool is $b greater than $a
     */
    protected static function __gt($a, $b)
    {
        return $b > $a;
    }

    /**
     * Greater Than Or Equal
     *
     * Returns true given $b is greater than or equal to $a.
     *
     * ```
     * $gte(1, 1); // True
     * $gte(1, 2); // True
     * ```
     *
     * @type mixed -> mixed -> Bool
     *
     * @param  mixed $a Value
     * @param  mixed $b Value to test
     * @return Bool is $b greater than or equal to $a
     */
    protected static function __gte($a, $b)
    {
        return $b >= $a;
    }

    /**
     * Less Than
     *
     * Returns true given $b is less than $a.
     *
     * ```
     * $lt(2, 1); // True
     * $lt(1, 2); // False
     * ```
     *
     * @type mixed -> mixed -> Bool
     *
     * @param  mixed $a Value
     * @param  mixed $b Value to test
     * @return Bool is $b less than $a
     */
    protected static function __lt($a, $b)
    {
        return $b < $a;
    }

    /**
     * Less Than Or Equal
     *
     * Returns true given $b is less than or equal to $a.
     *
     * ```
     * $lte(1, 1); // True
     * $lte(2, 1); // True
     * ```
     *
     * @type mixed -> mixed -> Bool
     *
     * @param  mixed $a Value
     * @param  mixed $b Value to test
     * @return Bool is $b less than or equal to $a
     */
    protected static function __lte($a, $b)
    {
        return $b <= $a;
    }

    /**
     * Equal (Not Strict / ==)
     *
     * Returns true given $a equals $b
     *
     * ```
     * $eq(1, 1); // True
     * $eq(1, 2); // False
     * ```
     *
     * @type mixed -> mixed -> Bool
     *
     * @param  mixed $a First value
     * @param  mixed $b Second value
     * @return Bool is $a equal to $b
     */
    protected static function __eq($a, $b)
    {
        return $a == $b;
    }

    /**
     * Equal (Strict / ===)
     *
     * Returns true given $a equals $b
     *
     * ```
     * $eq(1, 1); // True
     * $eq(1, '1'); // False
     * ```
     *
     * @type mixed -> mixed -> Bool
     *
     * @param  mixed $a First value
     * @param  mixed $b Second value
     * @return Bool is $a equal to $b
     */
    protected static function __eqStrict($a, $b)
    {
        return $a === $b;
    }

    /**
     * Logical Not
     *
     * Returns the inverse of $a
     *
     * ```
     * $not(false); // true
     * ```
     *
     * @type Bool -> Bool
     *
     * @param  bool $a Value to invert
     * @return bool    Inverted value
     */
    protected static function __not($a)
    {
        return !$a;
    }

    /**
     * Not Equal (Not Strict / ==)
     *
     * Returns true given $a does not equal $b
     *
     * ```
     * $notEq(1, 1); // False
     * $notEq(1, 2); // True
     * ```
     *
     * @type mixed -> mixed -> Bool
     *
     * @param  mixed $a First value
     * @param  mixed $b Second value
     * @return Bool is $a not equal to $b
     */
    protected static function __notEq($a, $b)
    {
        return $a != $b;
    }

    /**
     * Not Equal (Strict / ===)
     *
     * Returns true given $a does not equal $b
     *
     * ```
     * $notEqStrict(1, 2); // True
     * $notEqStrict(1, '1'); // False
     * ```
     *
     * @type mixed -> mixed -> Bool
     *
     * @param  mixed $a First value
     * @param  mixed $b Second value
     * @return Bool is $a not equal to $b
     */
    protected static function __notEqStrict($a, $b)
    {
        return $a !== $b;
    }

    /**
     * All
     *
     * Returns true given all values are truthy
     *
     * ```
     * $all(1, 'asdf', true); // True
     * $all(1, false); // False
     * ```
     *
     * @type array -> Bool
     *
     * @param  array $arr Values to test
     * @return Bool are all values truthy
     */
    protected static function __all($arr)
    {
        return ArrayList::foldl(self::using('logicalAnd'), true, $arr);
    }

    /**
     * Any
     *
     * Returns true given any values are truthy
     *
     * ```
     * $any(true, false); // True
     * $any(false, false); // False
     * ```
     *
     * @type array -> Bool
     *
     * @param  array $arr Values to test
     * @return Bool are any values truthy
     */
    protected static function __any($arr)
    {
        return ArrayList::foldl(self::using('logicalOr'), false, $arr);
    }
}
