<?php

use Vector\Algebra\Monad\Either;
use function Vector\Algebra\Lambda\fmap;

require(__DIR__ . '/vendor/autoload.php');

$test = Either::Right("Sup");

$addExclamation = function($str) {
    return $str . "!";
};

$result = fmap($addExclamation, $test);

var_dump($result);
