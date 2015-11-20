<?php

namespace Vector\Algebra\Lib;

use Vector\Util\FunctionCapsule;
use Vector\Algebra\Typeclass\Monad;

abstract class Monad extends FunctionCapsule
{
    protected static function bind($f, Monad $container)
    {
        return $container->bind($f);
    }
}
