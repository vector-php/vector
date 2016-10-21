<?php

namespace Vector\Control;

use Vector\Core\Module;
use Vector\Lib\Arrays;

abstract class Monad extends Module
{
    protected static function __bind($f, $container)
    {
        if (is_array($container)) {
            $result = [];
            $concat = Arrays::using('concat');

            foreach ($container as $x) {
                $result = $concat($result, $f($x));
            }

            return $result;
        }

        return $container->bind($f);
    }

    protected static function __kleisliCompose($f, $g)
    {
        return function($x) use ($f, $g) {
            $bind = self::Using('bind');

            return $bind($g, $f($x));
        };
    }
}
