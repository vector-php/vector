<?php

namespace Vector\Data\Maybe;

use Vector\Control\Pattern;
use Vector\Core\Module;
use Vector\Typeclass\SimpleApplicativeDefault;
use Vector\Typeclass\SimpleMonadDefault;
use Vector\Core\Curry;

abstract class Maybe
{
    use Module;
    use SimpleApplicativeDefault;
    use SimpleMonadDefault;

    #[Curry]
    protected static function withDefault($defaultValue, Maybe $value)
    {
        return Pattern::match([
            fn (Just $v) => $v->extract(),
            fn (Nothing $_) => $defaultValue,
        ])($value);
    }

    #[Curry]
    protected static function map(callable $func, Maybe $value)
    {
        return Pattern::match([
            fn (Just $v) => $func($v->extract()),
            fn (Nothing $_) => Maybe::nothing(),
        ])($value);
    }

    #[Curry]
    protected static function just($value)
    {
        return new Just($value);
    }

    public static function nothing()
    {
        return new Nothing;
    }
}
