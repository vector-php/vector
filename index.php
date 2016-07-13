<?php

require __DIR__ . '/vendor/autoload.php';

use phpDocumentor\Reflection\DocBlock;
use Vector\Lib\ArrayList;
use Vector\Core\Module;

class FooTest extends Module
{
    /**
     * Foo
     *
     * Does foo type things, such as fooing and barring
     *
     * @example
     * return testAssertion(FooTest::foo(), 7);
     *
     * @type Number
     *
     * @return int Always returns seven
     */
    protected static function __foo()
    {
        return 6;
    }
}

$prepend =
<<< 'EOP'
function testAssertion($a, $b) {
    return $a === $b;
}
EOP;

$append =
<<< 'EOA'

EOA;

$isFooTest = ArrayList::filter(function($f) {
    return $f->class === 'FooTest';
});

$moduleMethods = $isFooTest((new \ReflectionClass('FooTest'))->getMethods());

foreach ($moduleMethods as $function) {
    $doc = new DocBlock($function);

    $exampleRaw = $doc->getTagsByName('example')[0]->getContent();
    $exampleEval = $prepend . $exampleRaw . $append;

    var_dump(eval($exampleEval));
}
