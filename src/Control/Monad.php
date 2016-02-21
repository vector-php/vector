<?php

namespace Vector\Control;

use Vector\Core\Module;
use Vector\Typeclass\MonadInterface as TypeclassMonad;

abstract class Monad extends Module
{
    protected static function bind($f, TypeclassMonad $container)
    {
        return $container->bind($f);
    }

    protected static function kleisliCompose($f, $g)
    {
        return function($x) use ($f, $g) {
            $bind = self::Using('bind');

            return $bind($g, $f($x));
        };
    }
}
