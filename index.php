<?php

require __DIR__ . '/vendor/autoload.php';

use Vector\Control\Pattern;

class Foo extends \Vector\Core\Module
{
    protected static $memoize = ['fibonacci'];

    protected static function __fibonacci($n)
    {
        return Pattern::patternMatch([
            [ 0, function($_) { return 0; } ],
            [ 1, function($_) { return 1; } ],
            [ Pattern::any(), function($n) { return self::fibonacci($n - 1) + self::fibonacci($n - 2); } ]
        ])(func_get_args());
    }
}

echo Foo::fibonacci(21);
