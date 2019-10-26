<?php

namespace Vector\Data\Maybe;

use Vector\Core\Module;
use Vector\Typeclass\MonadInterface;
use Vector\Typeclass\SimpleApplicativeDefault;
use Vector\Typeclass\SimpleFunctorDefault;
use Vector\Typeclass\SimpleMonadDefault;

/**
 * @method static callable just($value)
 * @method static callable nothing()
 */
abstract class Maybe extends Module implements MonadInterface
{
    use SimpleFunctorDefault;
    use SimpleApplicativeDefault;
    use SimpleMonadDefault;

    protected static function __just($value)
    {
        return new Just($value);
    }

    protected static function __nothing()
    {
        return new Nothing;
    }
}
