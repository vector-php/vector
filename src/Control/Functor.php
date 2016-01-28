<?php

namespace Vector\Control;

use Vector\Core\FunctionCapsule;
use Vector\Typeclass\Functor as TypeclassFunctor;

abstract class Functor extends FunctionCapsule
{
    protected static function fmap($f, $container)
    {
        if (is_array($container))
            return array_map($f, $container);

        return $container->fmap($f);
    }

    protected static function extract(TypeclassFunctor $f)
    {
        return $f->extract();
    }
}
