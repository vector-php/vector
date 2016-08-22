<?php

require __DIR__ . '/vendor/autoload.php';

use Vector\Core\Structures;
use Vector\Data\Maybe;

$justThree = Maybe::nothing();
$default = 7;

$pattern = Structures::patternMatch(Maybe::class)
    ->just(function($value) {
        return $value;
    })
    ->nothing(function() use ($default) {
        return $default;
    });

$res = $pattern($justThree);

var_dump($res);
