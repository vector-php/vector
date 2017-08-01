<?php

require __DIR__ . '/vendor/autoload.php';

use Vector\Control\Pattern;
use Vector\Lib\Lambda;
use Vector\Lib\Logic;

class Foo extends \Vector\Core\Module
{
    protected static $memoize = ['fibonacci'];

    protected static function __fibonacci(...$n)
    {
        return Pattern::match([
            [ Logic::eqStrict(0), Lambda::always(0) ],
            [ Logic::eqStrict(1), Lambda::always(1) ],
            [
                Pattern::any(),
                function ($n) {
                    return self::fibonacci($n - 1) + self::fibonacci($n - 2);
                }
            ]
        ])(...$n);
    }
}

echo Foo::fibonacci(21);
