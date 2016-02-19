<?php

require __DIR__ . '/vendor/autoload.php';

use Vector\Lib\Lambda;
use Vector\Data\Maybe;
use Vector\Control\Lens;
use Vector\Control\Applicative;

$compose = Lambda::using('compose');
$pure = Applicative::using('pure');
list($lens, $view) = Lens::using('propLens', 'view');

$test = new \StdClass();
$test->foo = 'bar';

$propFoo = $lens('baz');

echo $view($propFoo, $test);
