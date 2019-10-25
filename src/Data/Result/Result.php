<?php

namespace Vector\Data\Result;

use Exception;
use Vector\Core\Module;
use Vector\Typeclass\SimpleApplicativeDefault;
use Vector\Typeclass\SimpleFunctorDefault;
use Vector\Typeclass\SimpleMonadDefault;
use Vector\Typeclass\MonadInterface;

/**
 * @method static callable ok($value)
 * @method static callable err(...$args)
 * @method static callable from(...$args)
 */
abstract class Result extends Module implements MonadInterface
{
    use SimpleFunctorDefault;
    use SimpleApplicativeDefault;
    use SimpleMonadDefault;

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
