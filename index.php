<?php

require __DIR__ . '/vendor/autoload.php';

use phpDocumentor\Reflection\DocBlock;
use Vector\Lib\{ArrayList, Object, Lambda};
use Vector\Core\Module;

$obj = new StdClass();

$objNew = Object::assign(['foo' => 'bar'], $obj);
