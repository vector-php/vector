<?php

namespace Vector\Lib;

use Vector\Core\Module;

/**
 * @method static callable pipe(...$args)
 * @method static callable compose(...$args)
 * @method static callable k(...$args)
 * @method static callable always(...$args)
 * @method static mixed id(...$args)
 * @method static mixed flip(...$args)
 * @method static mixed apply(...$args)
 */
abstract class Lambda extends Module
{
    protected static function __pipe(...$fs)
    {
        return function ($inputArg) use ($fs) {
            return array_reduce($fs, function ($carry, $f) {
                return $f($carry);
            }, $inputArg);
        };
    }

    protected static function __dot($f, $g)
    {
        return function ($x) use ($f, $g) {
            return $f($g($x));
        };
    }

    protected static function __apply($f, $x)
    {
        return $f($x);
    }

    protected static function __compose(...$fs)
    {
        return self::pipe(...array_reverse($fs));
    }

    /**
     * Flip Combinator
     *
     * Given a function that takes two arguments, return a new function that
     * takes those two arguments with their order reversed.
     *
     * @param \Closure $f Function to flip
     * @return \Closure    Flipped function
     * @example
     * Math::subtract(2, 6); // 4
     * Lambda::flip(Math::subtract())(2, 6); // -4
     *
     * @type (a -> b -> c) -> b -> a -> c
     *
     */
    protected static function __flip($f)
    {
        return self::curry(function ($a, $b) use ($f) {
            return $f($b, $a);
        });
    }

    /**
     * K Combinator
     *
     * Given some value k, return a lambda expression which always evaluates to k, regardless
     * of any arguments it is given.
     *
     * @param mixed $k Value to express in the combinator
     * @return \Closure    Expression which always returns $k
     * @example
     * $alwaysFour = Lambda::k(4);
     * $alwaysFour('foo'); // 4
     * $alwaysFour(1, 2, 3); // 4
     * $alwaysFour(); // 4
     *
     * @type a -> (b -> a)
     *
     */
    protected static function __k($k)
    {
        return function (...$null) use ($k) {
            return $k;
        };
    }

    /**
     * Identity Function
     *
     * Given some value a, return a unchanged
     *
     * @param mixed $a Value to return
     * @return mixed    The given value, unchanged
     * @example
     * Lambda::id(4); // 4
     * Lambda::id('foo'); // 'foo'
     *
     * @type a -> a
     *
     */
    protected static function __id($a)
    {
        return $a;
    }

    protected static function __always($value)
    {
        return static::k($value);
    }
}
