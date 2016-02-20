<?php

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;
use \phpDocumentor\Reflection\DocBlock;
use Vector\Lib\Math;

$getFunctionDoc = function($class, $f) {
    return new DocBlock(new ReflectionMethod($class, $f));
};

$doc = $getFunctionDoc(Math::class, 'pow');

print_r(Yaml::dump(['a' => 1]));
