<?php

namespace Vector\Lib;

use Vector\Core\Curry;
use Vector\Core\Module;

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
    #[Curry]
    protected static function orCombinator(array $fs, $a)
    {
        return self::using('any')(Arrays::map(function ($c) use ($a) {
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
    #[Curry]
    protected static function andCombinator(array $fs, $a)
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
    #[Curry]
    protected static function logicalOr($a, $b)
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
    #[Curry]
    protected static function logicalNot($a)
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
    #[Curry]
    protected static function logicalAnd($a, $b)
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
    #[Curry]
    protected static function gt($a, $b)
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
    #[Curry]
    protected static function gte($a, $b)
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
    #[Curry]
    protected static function lt($a, $b)
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
    #[Curry]
    protected static function lte($a, $b)
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
    #[Curry]
    protected static function eq($a, $b)
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
    #[Curry]
    protected static function eqStrict($a, $b)
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
    #[Curry]
    protected static function notEq($a, $b)
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
    #[Curry]
    protected static function notEqStrict($a, $b)
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
    #[Curry]
    protected static function all($arr)
    {
        return Arrays::reduce(self::using('logicalAnd'), true, $arr);
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
    #[Curry]
    protected static function any($arr)
    {
        return Arrays::reduce(self::using('logicalOr'), false, $arr);
    }
}
