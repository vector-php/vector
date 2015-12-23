<?php

use Vector\Util\FunctionCapsule;

use Vector\Algebra\Monad\Maybe;
use Vector\Algebra\Monad\Reader;

use Vector\Algebra\Lib\Reader as ReaderLib;
use Vector\Algebra\Lib\Monad;
use Vector\Algebra\Lib\Lambda;

require(__DIR__ . '/vendor/autoload.php');

class App extends FunctionCapsule
{
    protected static function greet($name)
    {
        $bind    = Monad::using('bind');
        $ask     = ReaderLib::using('ask');

        $greeter = function($ctx) use ($name) {
            return Reader::pure($ctx . ", " . $name);
        };

        return $bind($greeter, $ask());
    }
}

$runReader = ReaderLib::using('runReader');
$greet     = App::using('greet');

echo $runReader($greet("Joseph"), "Hello");