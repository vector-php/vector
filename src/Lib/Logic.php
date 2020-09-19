<?php

namespace Vector\Lib;

use Vector\Core\Module;

/**
 * @method static callable orCombinator(...$args)
 * @method static callable andCombinator(...$args)
 * @method static callable logicalOr(...$args)
 * @method static callable logicalNot(...$args)
 * @method static callable logicalAnd(...$args)
 * @method static callable gt(...$args)
 * @method static callable gte(...$args)
 * @method static callable lt(...$args)
 * @method static callable lte(...$args)
 * @method static callable eq(...$args)
 * @method static callable eqStrict(...$args)
 * @method static callable notEq(...$args)
 * @method static callable notEqStrict(...$args)
 * @method static callable all(...$args)
 * @method static callable any(...$args)
 */
class Logic
{
    use Module;

    /**
     * Logical Or Combinator
     *
     * Given n functions {f1, f2, ..., fn}, combine them in such a way to produce a new
     * function g that returns true given at least one of {f1(x), f2(x), ... fn(x)} return true.
     *
     * @param array $fs array of functions to combine
     * @param mixed $a value to test
     * @return \Closure test for or using provided functions
     * @example
     * $funcF = function($x) { return $x >= 5; };
     * $funcG = function($x) { return $x == 0; };
     * $combinator = Logic::orCombinator([$funcF, $funcG]);
     * $combinator(9); // True
     * $combinator(0); // True
     * $combinator(2); // False
     *
     * @type [(a -> Bool)] -> a -> Bool
     *
     */
    protected static function __orCombinator(array $fs, $a)
    {
        return self::any(Arrays::map(function ($c) use ($a) {
            return $c($a);
        }, $fs));
    }

    /**
     * Logical And Combinator
     *
     * Given n functions {f1, f2, ..., fn}, combine them in such a way to produce a new
     * function g that returns true given {f1(x), f2(x), ... fn(x)} all return true.
     *
     * @param array $fs array of functions to combine
     * @param mixed $a value to test
     * @return \Closure test for or using provided functions
     * @example
     * $funcF = function($x) { return $x < 5; };
     * $funcG = function($x) { return $x > 0; };
     * $combinator = Logic::andCombinator([$funcF, $funcG]);
     * $combinator(4); // True
     * $combinator(2); // True
     * $combinator(7); // False
     *
     * @type [(a -> Bool)] -> a -> Bool
     *
     */
    protected static function __andCombinator(array $fs, $a)
    {
        return self::all(Arrays::map(function ($c) use ($a) {
            return $c($a);
        }, $fs));
    }

    /**
     * Logical Or
     *
     * Returns true given $a OR $b returns true.
     *
     * @param mixed $a First value
     * @param mixed $b Second value
     * @return Bool Result of OR
     * @example
     * Logic::logicalOr(false, false); // False
     *
     * @type Bool -> Bool -> Bool
     *
     * @example
     * Logic::logicalOr(true, false); // True
     *
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
     * @param mixed $a value
     * @return Bool Result of NOT
     * @example
     * Logic::logicalNot(true); // False
     *
     * @example
     * Logic::logicalNot(false); // True
     *
     * @type Bool -> Bool
     *
     */
    protected static function __logicalNot($a)
    {
        return ! $a;
    }

    /**
     * Logical And
     *
     * Returns true given $a AND $b are true.
     *
     * @param mixed $a First value
     * @param mixed $b Second value
     * @return Bool Result of AND
     * @example
     * Logic::logicalAnd(true, false); // False
     *
     * @type Bool -> Bool -> Bool
     *
     * @example
     * Logic::logicalAnd(true, true); // True
     *
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
     * @param mixed $a Value
     * @param mixed $b Value to test
     * @return Bool is $b greater than $a
     * @example
     * Logic::gt(1, 2); // True
     *
     * @type mixed -> mixed -> Bool
     *
     * @example
     * Logic::gt(2, 1); // False
     *
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
     * @param mixed $a Value
     * @param mixed $b Value to test
     * @return Bool is $b greater than or equal to $a
     * @example
     * Logic::gte(1, 2); // True
     *
     * @type mixed -> mixed -> Bool
     *
     * @example
     * Logic::gte(1, 1); // True
     *
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
     * @param mixed $a Value
     * @param mixed $b Value to test
     * @return Bool is $b less than $a
     * @example
     * Logic::lt(1, 2); // False
     *
     * @type mixed -> mixed -> Bool
     *
     * @example
     * Logic::lt(2, 1); // True
     *
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
     * @param mixed $a Value
     * @param mixed $b Value to test
     * @return Bool is $b less than or equal to $a
     * @example
     * Logic::lte(2, 1); // True
     *
     * @type mixed -> mixed -> Bool
     *
     * @example
     * Logic::lte(1, 1); // True
     *
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
     * @param mixed $a First value
     * @param mixed $b Second value
     * @return Bool is $a equal to $b
     * @example
     * Logic::eq(1, 2); // False
     *
     * @type mixed -> mixed -> Bool
     *
     * @example
     * Logic::eq(1, 1); // True
     *
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
     * @param mixed $a First value
     * @param mixed $b Second value
     * @return Bool is $a equal to $b
     * @example
     * Logic::eqStrict(1, '1'); // False
     *
     * @type mixed -> mixed -> Bool
     *
     * @example
     * Logic::eqStrict(1, 1); // True
     *
     */
    protected static function __eqStrict($a, $b)
    {
        return $a === $b;
    }

    /**
     * Not Equal (Not Strict / ==)
     *
     * Returns true given $a does not equal $b
     *
     * @param mixed $a First value
     * @param mixed $b Second value
     * @return Bool is $a not equal to $b
     * @example
     * Logic::notEq(1, 2); // True
     *
     * @type mixed -> mixed -> Bool
     *
     * @example
     * Logic::notEq(1, 1); // False
     *
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
     * @param mixed $a First value
     * @param mixed $b Second value
     * @return Bool is $a not equal to $b
     * @example
     * Logic::notEqStrict(1, '1'); // False
     *
     * @type mixed -> mixed -> Bool
     *
     * @example
     * Logic::notEqStrict(1, 2); // True
     *
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
     * @param array $arr Values to test
     * @return Bool are all values truthy
     * @example
     * Logic::all(1, 'asdf', true); // True
     *
     * @example
     * Logic::all(1, false); // False
     *
     * @type array -> Bool
     *
     */
    protected static function __all($arr)
    {
        /** @noinspection PhpParamsInspection */
        return Arrays::reduce(self::logicalAnd(), true, $arr);
    }

    /**
     * Any
     *
     * Returns true given any values are truthy
     *
     * @param array $arr Values to test
     * @return Bool are any values truthy
     * @example
     * Logic::any(true, false); // True
     *
     * @example
     * Logic::any(false, false); // False
     *
     * @type array -> Bool
     *
     */
    protected static function __any($arr)
    {
        /** @noinspection PhpParamsInspection */
        return Arrays::reduce(self::logicalOr(), false, $arr);
    }
}
