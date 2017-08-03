<?php

namespace Vector\Data\Either;

use Vector\Control\Functor;
use Vector\Core\Module;
use Vector\Data\Maybe\Just;
use Vector\Typeclass\IsApplicative;
use Vector\Typeclass\IsFunctor;
use Vector\Typeclass\IsMonad;
use Vector\Typeclass\MonadInterface;

/**
 * Class Either
 * @package Vector\Data
 */
class Either extends Module implements MonadInterface
{
    use IsFunctor;
    use IsApplicative;
    use IsMonad;

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
