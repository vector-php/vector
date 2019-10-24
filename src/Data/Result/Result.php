<?php

namespace Vector\Data\Result;

use Exception;
use Vector\Core\Module;
use Vector\Typeclass\simpleApplicativeDefault;
use Vector\Typeclass\simpleFunctorDefault;
use Vector\Typeclass\simpleMonadDefault;
use Vector\Typeclass\MonadInterface;

abstract class Result extends Module implements MonadInterface
{
    use simpleFunctorDefault;
    use simpleApplicativeDefault;
    use simpleMonadDefault;

    protected static function __ok($value)
    {
        return new Ok($value);
    }

    protected static function __err($err)
    {
        return new Err($err);
    }

    protected static function attempt(callable $f)
    {
        try {
            return Result::ok($f());
        } catch (Exception $e) {
            return Result::err($e);
        }
    }
}
