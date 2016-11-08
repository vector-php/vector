<?php

require __DIR__ . '/vendor/autoload.php';

use Vector\Control\Pattern;

class Foo extends \Vector\Core\Module
{
    protected static $memoize = ['fibonacci'];

    protected static function __fibonacci($n)
    {
        return Pattern::patternMatch([
            [ 0, Lambda::k(0) ],
            [ 1, Lambda::k(1) ],
            [ Pattern::_, function($n) { return self::fibonacci($n - 1) + self::fibonacci($n - 2); } ]
        ])(...func_get_args());
    }
}

echo Foo::fibonacci(21);
