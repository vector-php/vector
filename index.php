<?php

use Vector\Control\Functor;
use Vector\Control\Pattern;
use Vector\Data\Constant;
use Vector\Data\Maybe\Just;
use Vector\Data\Maybe\Nothing;
use Vector\Lib\Lambda;
use Vector\Lib\Math;

require __DIR__ . '/vendor/autoload.php';

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

// New tests

$thing = new Just(3);
$noThing = new Nothing();

$addOne = Math::add(1);

var_dump(Functor::fmap($addOne, $thing)); // This should be Just(4);
var_dump(Functor::fmap($addOne, $noThing)); // This should be Nothing;

$five = Constant::pure(5);

$addOne = Math::add(1);

var_dump(Functor::fmap($addOne, $five)); // Should be Constant(5)
