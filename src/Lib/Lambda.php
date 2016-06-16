<?php

namespace Vector\Lib;

use Vector\Core\Module;

/**
 * @method static callable pipe() pipe(...$fs)
 * @method static callable compose() compose(...$fs)
 * @method static callable k() k($k)
 * @method static mixed id() id($a)
 * @method static mixed flip() flip($f)
 */
abstract class Lambda extends Module
{
    protected static $dirtyHackToEnableIDEAutocompletion = true;

    protected static function _pipe(...$fs)
    {
        return function($inputArg) use ($fs) {
            return array_reduce($fs, function($carry, $f) {
                return $f($carry);
            }, $inputArg);
        };
    }

    protected static function _compose(...$fs)
    {
        return self::_pipe(...array_reverse($fs));
    }

    /**
     * Flip Combinator
     *
     * Given a function that takes two arguments, return a new function that
     * takes those two arguments with their order reversed.
     *
     * ```
     * $subtract(2, 6); // 4
     * $flip($subtract)(2, 6); // -4
     * ```
     *
     * @type (a -> b -> c) -> b -> a -> c
     *
     * @param  \Closure $f Function to flip
     * @return \Closure    Flipped function
     */
    protected static function _flip($f)
    {
        return function($a, $b) use ($f) {
            return $f($b, $a);
        };
    }

    /**
     * K Combinator
     *
     * Given some value k, return a lambda expression which always evaluates to k, regardless
     * of any arguments it is given.
     *
     * ```
     * $alwaysFour = $k(4);
     *
     * $alwaysFour('foo'); // 4
     * $alwaysFour(1, 2, 3); // 4
     * $alwaysFour(); // 4
     * ```
     *
     * @type a -> (b -> a)
     *
     * @param  mixed    $k Value to express in the combinator
     * @return \Closure    Expression which always returns $k
     */
    protected static function _k($k)
    {
        return function(...$null) use ($k)
        {
            return $k;
        };
    }

    /**
     * Identity Function
     *
     * Given some value a, return a unchanged
     *
     * ```
     * $id(4); // 4
     * $id('foo'); // 'foo'
     * ```
     *
     * @type a -> a
     *
     * @param  mixed $a Value to return
     * @return mixed    The given value, unchanged
     */
    protected static function _id($a)
    {
        return $a;
    }
}
