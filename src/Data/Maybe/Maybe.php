<?php

namespace Vector\Data\Maybe;

use Vector\Control\Pattern;
use Vector\Core\Module;
use Vector\Typeclass\SimpleApplicativeDefault;
use Vector\Typeclass\SimpleMonadDefault;

/**
 * @method static callable just($value)
 * @method static callable nothing()
 * @method static callable withDefault($value)
 */
abstract class Maybe extends Module
{
    use SimpleApplicativeDefault;
    use SimpleMonadDefault;

    public static function __withDefault($defaultValue, Maybe $value)
    {
        return Pattern::match([
            fn (Just $v) => $v->extract(),
            fn (Nothing $_) => $defaultValue,
        ])($value);
    }

    public static function __map(callable $func, Maybe $value)
    {
        return Pattern::match([
            fn (Just $v) => $func($v->extract()),
            fn (Nothing $_) => Maybe::nothing(),
        ])($value);
    }

    protected static function __just($value)
    {
        return new Just($value);
    }

    protected static function __nothing()
    {
        return new Nothing;
    }
}
