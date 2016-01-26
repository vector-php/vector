<?php

namespace Vector\Lib;

use Vector\Core\FunctionCapsule;

abstract class Lambda extends FunctionCapsule
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
}
