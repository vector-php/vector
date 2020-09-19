<?php

namespace Vector\Data\Result;

use Exception;
use Vector\Core\Module;

/**
 * @method static callable ok($value)
 * @method static callable err(...$args)
 * @method static callable from(...$args)
 */
abstract class Result
{
    use Module;

    protected static function __ok($value)
    {
        return new Ok($value);
    }

    protected static function __err($err)
    {
        return new Err($err);
    }

    protected static function __from(callable $f)
    {
        try {
            return Result::ok($f());
        } catch (Exception $e) {
            return Result::err($e);
        }
    }
}
