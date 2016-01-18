<?php

namespace Vector\Algebra\Lib;

use Vector\Util\FunctionCapsule;
use Vector\Algebra\Typeclass\Monad as TypeclassMonad;

abstract class Monad extends FunctionCapsule
{
    protected static function bind($f, TypeclassMonad $container)
    {
        return $container->bind($f);
    }
}
