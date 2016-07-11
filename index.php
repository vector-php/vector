<?php

require __DIR__ . '/vendor/autoload.php';

use Vector\Data\Either;
use Vector\Control\Applicative;
use Vector\Lib\Logic;
use Vector\Lib\Lambda;
use Vector\Lib\ArrayList;

function all($fs, $a) {
    return ArrayList::foldl(Logic::logicalAnd(), true, Applicative::apply($fs, Applicative::pure([], $a)));
}

var_dump(all([function($a) { return $a > 4; }, function($a) { return $a < 10; }], 10));
