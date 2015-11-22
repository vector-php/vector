<?php

namespace Vector\Algebra\Lib;

use Vector\Util\FunctionCapsule;
use Vector\Algebra\Typeclass\Functor;

abstract class Functor extends FunctionCapsule
{
    protected static function fmap($f, Functor $container)
    {
        return $container->fmap($f);
    }

    protected static function extract(Functor $f)
    {
        return $f->extract();
    }
}
