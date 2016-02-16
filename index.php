<?php

require __DIR__ . '/vendor/autoload.php';

use Vector\Core\Interpreter;

$vectorInterpretor = (new Interpreter())
    ->using('Vector\Lib\Math')
    ->using('Vector\Control\Functor');

$meanFunction = $vectorInterpretor->expand('mean . fmap (add 10)');

echo $meanFunction([5, 5, 25, 10, 0]); // 19
