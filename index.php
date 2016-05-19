<?php

require __DIR__ . '/vendor/autoload.php';

use Vector\Lib\Lambda;
use Vector\Control\Lens;

$testArray = ['foo' => [], 'bar' => ['bing' => 9]];

var_dump(
    Lens::set(Lens::pathLensSafe(['foo', 'bar', 'baz']), 7, $testArray)
);

var_dump(
    Lens::view(Lens::pathLensSafe(['foo', 'bar']), $testArray)
);

var_dump(
    Lens::view(Lens::pathLensSafe(['bar', 'bing']), $testArray)
);
