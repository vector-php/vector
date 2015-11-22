<?php

use Vector\Util\FunctionCapsule;

use Vector\Algebra\Monad\Maybe;

use Vector\Algebra\Lib\Applicative;
use Vector\Algebra\Lib\Lambda;

require(__DIR__ . '/vendor/autoload.php');

class App extends FunctionCapsule
{
    protected static function add($a, $b)
    {
        return $a + $b;
    }
}

$liftA2  = Applicative::using('liftA2');
$compose = Lambda::using('compose');
$add     = App::using('add');

$nothing = Maybe::Nothing();
$justOne = Maybe::Just(1);
$justTwo = Maybe::Just(2);

$maybeAdd = $liftA2(Maybe::class, $add);

var_dump($maybeAdd($justOne, $justTwo)); // Just 3
var_dump($maybeAdd($justOne, $nothing)); // Nothing
var_dump($maybeAdd($nothing, $justTwo)); // Nothing
