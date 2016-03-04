<?php

namespace Vector\Lib;

use Vector\Core\Module;

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
     * $combinator = $orCombinator($funcF, $funcG);
     *
     * $combinator(9); // True
     * $combinator(0); // True
     * $combinator(2); // False
     * ```
     *
     * @type (a -> Bool) -> (a -> Bool) -> (a -> Bool)
     *
     * @param  callable $f First function to combine
     * @param  callable $g Second function to combine
     * @return \Closure    Result of f(x) or g(x)
     */
    protected static function orCombinator(Callable $f, Callable $g)
    {
        return function ($x) use ($f, $g) {
            return $f($x) || $g($x);
        };
    }

    protected static function logicalOr($a, $b)
    {
        return $a || $b;
    }

    protected static function logicalNot($a)
    {

    }

    protected static function logicalAnd($a, $b)
    {

    }

    protected static function gt($a, $b)
    {
        return $b > $a;
    }

    protected static function eq($a, $b)
    {
        return $a == $b;
    }
}
