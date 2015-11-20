<?php

use Vector\Util\FunctionCapsule;

use Vector\Algebra\Monad\Maybe;

use Vector\Algebra\Lib\Applicative;
use Vector\Algebra\Lib\Lambda;

require(__DIR__ . '/vendor/autoload.php');

class Temp extends FunctionCapsule
{
    protected static function add($a, $b, $c)
    {
        return $a + $b + $c;
    }
}

list($pure, $apply) = Applicative::using('pure', 'apply');
$compose            = Lambda::using('compose');
$add                = Temp::using('add');

$justOne = Maybe::Just(1);
$justTwo = Maybe::Just(2);

$pureAdd = $pure(Maybe::class, $add); // We want the Maybe instance of pure()

$argOneApplied = $apply($pureAdd, $justOne);
$argTwoApplied = $apply($argOneApplied, $justTwo);
$result        = $apply($argTwoApplied, $justOne);

$pipe($pure(Maybe::class, $add), $apply, $justOne, $apply, $justTwo, $apply, $justOne);
// Can be used to write a liftAN Function, e.g.
// $liftA2($add, $justOne, $justTwo);

var_dump($result);
