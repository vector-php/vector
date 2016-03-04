<?php

require __DIR__ . '/vendor/autoload.php';

use Vector\Control\Monad;
use Vector\Control\Applicative;
use Vector\Lib\Lambda;
use Vector\Lib\Logic;
use Vector\Lib\ArrayList;

// Returns true if any element in the list is greater than 2 or equal to 0
// foldl (||) False . (<*>) [(> 2), (== 0)]
$any = Lambda::compose(
    ArrayList::foldl(
        Logic::logicalOr(),
        false
    ),
    Applicative::apply(
        [Logic::gt(2), Logic::eq(0)]
    )
);

var_dump($any([1, 2])); // False
var_dump($any([1, 2, 3])); // True

$res = Monad::bind(ArrayList::replicate(2), [1, 2, 3]);

print_r($res);
