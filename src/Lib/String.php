<?php

namespace Vector\Lib;

use Vector\Core\FunctionCapsule;

class String extends FunctionCapsule
{
    // String -> String -> String
    protected static function concat($addition, $original)
    {
        return $original . $addition;
    }
}
