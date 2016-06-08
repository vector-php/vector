<?php

require __DIR__ . '/vendor/autoload.php';

use Vector\Lib\Logic;
use Vector\Lib\Lambda;
use Vector\Lib\ArrayList;

$isFoo = Logic::eq('foo');

$isNotFoo = Lambda::compose(Logic::logicalNot(), $isFoo);

var_dump($isNotFoo('foo'));
