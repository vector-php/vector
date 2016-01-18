<?php

namespace Vector\Algebra\Lib;

use Vector\Util\FunctionCapsule;
use Vector\Algebra\Typeclass\Functor as TypeclassFunctor;

abstract class Functor extends FunctionCapsule
{
    protected static function fmap($f, TypeclassFunctor $container)
    {
        return $container->fmap($f);
    }

    protected static function extract(TypeclassFunctor $f)
    {
        return $f->extract();
    }
}
