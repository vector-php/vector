<?php

namespace Vector\Control;

use Vector\Core\FunctionCapsule;
use Vector\Typeclass\Monad as TypeclassMonad;

abstract class Monad extends FunctionCapsule
{
    protected static function bind($f, TypeclassMonad $container)
    {
        return $container->bind($f);
    }
}
