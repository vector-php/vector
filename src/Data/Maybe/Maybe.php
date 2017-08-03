<?php

namespace Vector\Data\Maybe;

use Vector\Core\Module;
use Vector\Typeclass\simpleApplicativeDefault;
use Vector\Typeclass\simpleFunctorDefault;
use Vector\Typeclass\simpleMonadDefault;
use Vector\Typeclass\MonadInterface;

/**
 * Class Maybe
 * @package Vector\Data
 * @method static callable just($value)
 * @method static callable nothing()
 */
abstract class Maybe extends Module implements MonadInterface
{
    use simpleFunctorDefault;
    use simpleApplicativeDefault;
    use simpleMonadDefault;

    // Constructors

    /**
     * @param $value
     * @return Just
     */
    protected static function __just($value)
    {
        return new Just($value);
    }

    /**
     * @return Nothing
     */
    protected static function __nothing()
    {
        return new Nothing;
    }
}
