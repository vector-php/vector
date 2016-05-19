<?php

require __DIR__ . '/vendor/autoload.php';

use Vector\Lib\Lambda;
use Vector\Control\Lens;

$testArray = ['foo' => ['bar' => 'baz']];

var_dump(
    Lens::view(Lens::pathLensSafe(['foo', 'bar']), $testArray)
);
