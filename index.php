<?php

require __DIR__ . '/vendor/autoload.php';

use Vector\Lib\ArrayList;
use Vector\Control\Functor;
use Vector\Lib\Math;
use Vector\Lib\Lambda;

class Foo {
    public static function bar() {
        return 4;
    }
}

$a = [1, 2, 3];

$b = Functor::fmap(
    Math::add(1),
    $a
);

$f = Lambda::compose(
    Functor::fmap(Math::add(1)),
    ArrayList::head()
);

$c = $f([[1, 2, 3], [2, 3, 4]]);
