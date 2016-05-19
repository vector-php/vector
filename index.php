<?php

require __DIR__ . '/vendor/autoload.php';

use Vector\Lib\Logic;
use Vector\Lib\Object;
use Vector\Lib\Lambda;
use Vector\Lib\ArrayList;
use Vector\Control\Lens;

class TestClass
{
    public function __construct()
    {
        //
    }
}

$testArray = [new TestClass(), new TestClass(), new TestClass(), 7];

$allTests = Lambda::compose(Logic::all(), ArrayList::map(Object::isInstanceOf(TestClass::class)));

var_dump($allTests($testArray));
