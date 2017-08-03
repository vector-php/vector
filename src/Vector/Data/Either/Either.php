<?php

namespace Vector\Data\Either;

use Vector\Control\Functor;
use Vector\Core\Module;
use Vector\Data\Maybe\Just;
use Vector\Typeclass\simpleApplicativeDefault;
use Vector\Typeclass\simpleFunctorDefault;
use Vector\Typeclass\simpleMonadDefault;
use Vector\Typeclass\MonadInterface;

/**
 * Class Either
 * @package Vector\Data
 */
class Either extends Module implements MonadInterface
{
    use simpleFunctorDefault;
    use simpleApplicativeDefault;
    use simpleMonadDefault;

    // Constructors

    protected static function __left($error)
    {
        return new Left($error);
    }

    protected static function __right($value)
    {
        return new Right($value);
    }

    // Either Methods

    protected static function __fromMaybe($leftValue, $maybeValue)
    {
        return $maybeValue instanceof Just
            ? Either::right($maybeValue->extract()[0])
            : Either::left($leftValue);
    }
}
