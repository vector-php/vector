<?php

namespace Vector\Data\Result;

use Exception;
use Vector\Core\Module;
use Vector\Core\Curry;

abstract class Result
{
    use Module;

    #[Curry]
    protected static function ok($value)
    {
        return new Ok($value);
    }

    #[Curry]
    protected static function err($err)
    {
        return new Err($err);
    }

    #[Curry]
    protected static function from(callable $f)
    {
        try {
            return Result::ok($f());
        } catch (Exception $e) {
            return Result::err($e);
        }
    }
}
