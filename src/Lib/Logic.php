<?php

namespace Vector\Lib;

use Vector\Core\Module;

use Vector\Lib\ArrayList;

/**
 * @method static callable orCombinator() orCombinator($f, $g)
 * @method static callable logicalOr() logicalOr($f, $g)
 * @method static callable logicalNot() logicalNot($a)
 * @method static callable logicalAnd() logicalAnd($a, $b)
 * @method static callable gt() gt($a, $b)
 * @method static callable gte() gte($a, $b)
 * @method static callable lt() lt($a, $b)
 * @method static callable lte() lte($a, $b)
 * @method static callable eq() eq($a, $b)
 * @method static callable eqStrict() eqStrict($a, $b)
 * @method static callable notEq() notEq($a, $b)
 * @method static callable notEqStrict() notEqStrict($a, $b)
 * @method static callable all() all($arr)
 * @method static callable any() any($arr)
 */
class Logic extends Module
{
    protected static $dirtyHackToEnableIDEAutocompletion = true;

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
     * @param  callable $f First function to combine
     * @param  callable $g Second function to combine
     * @return \Closure    Result of f(x) or g(x)
     */
    protected static function _orCombinator($fs)
    {

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
    protected static function _logicalOr($a, $b)
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
    protected static function _logicalNot($a)
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
    protected static function _logicalAnd($a, $b)
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
    protected static function _gt($a, $b)
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
    protected static function _gte($a, $b)
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
    protected static function _lt($a, $b)
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
    protected static function _lte($a, $b)
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
    protected static function _eq($a, $b)
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
    protected static function _eqStrict($a, $b)
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
    protected static function _not($a)
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
    protected static function _notEq($a, $b)
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
    protected static function _notEqStrict($a, $b)
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
    protected static function _all($arr)
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
    protected static function _any($arr)
    {
        return ArrayList::foldl(self::using('logicalOr'), false, $arr);
    }
}
