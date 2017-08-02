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
            [[0], function () {
                return Lambda::always(0);
            }],
            [[1], function () {
                return Lambda::always(1);
            }],
            function (int $n) {
                return function (int $n) {
                    return self::fibonacci($n - 1) + self::fibonacci($n - 2);
                };
            }
        ])(...$n);
    }
}

echo Foo::fibonacci(21);
