<?php

namespace Vector\Core;

use Vector\Core\Structures\PatternMatch;

class Structures
{
    public static function patternMatch($patternClass)
    {
        return new PatternMatch($patternClass);
    }
}
