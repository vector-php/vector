<?php

namespace Vector\Lib;

use Vector\Core\Module;

class Logic extends Module
{
    // (a -> Bool) -> (a -> Bool) -> a -> Bool
    protected static function logicalOr($f, $g)
    {
        return function ($x) use ($f, $g) {
            return $f($x) || $g($x);
        };
    }
}
