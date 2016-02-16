<?php

require __DIR__ . '/vendor/autoload.php';

use Vector\Core\Interpreter;

$v = (new Interpreter())
    ->using('Vector\Lib\Math')
    ->using('Vector\Lib\Strings')
    ->using('Vector\Control\Functor');

print_r($v->expand('join " " . fmap (concat "!") . split " "')("Hello World"));
