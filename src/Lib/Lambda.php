<?php

namespace Vector\Lib;

use Vector\Core\Module;

abstract class Lambda extends Module
{
    protected static function pipe(...$fs)
    {
        return function(...$args) use ($fs) {
            $carry = null;

            foreach ($fs as $f) {
                $carry = $carry
                    ? $f($carry)
                    : $f(...$args);
            }

            return $carry;
        };
    }

    protected static function compose(...$fs)
    {
        return self::pipe(...array_reverse($fs));
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
    protected static function k($k)
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
    protected static function id($a)
    {
        return $a;
    }
}
