<?php

use Vector\Control\Pattern;
use Vector\Control\Type;
use Vector\Data\Maybe;
use Vector\Lib\Arrays;
use Vector\Lib\Math;

require __DIR__ . '/vendor/autoload.php';

/** @noinspection PhpUndefinedMethodInspection */
$justOnes = Maybe::just([1, 1]);

/** @noinspection PhpParamsInspection */
$addTwo = Math::add(2);

/** @noinspection PhpParamsInspection */
$value = Pattern::match([
    [Pattern::just([1, 1]), Arrays::map($addTwo)],
//    [Pattern::just(), Arrays::map($addTwo)],
//    [Pattern::any(), function ($list) {
//        return $list;
//    }],
])($justOnes);

var_dump($value);
