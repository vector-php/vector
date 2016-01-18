<?php

namespace Vector\Algebra\Lib\__tests__;

use Vector\Algebra\Lib\Functor;
use Vector\Algebra\Lib\Lambda;
use Vector\Algebra\Lib\Maybe;
use Vector\Algebra\Lib\Monad;
use Vector\Algebra\Monad\Maybe as MaybeMonad;

class MaybeTest extends \PHPUnit_Framework_TestCase
{
    public function testMaybeGetValueAtIndex()
    {
        $compose = Lambda::using('compose');
        $map = Functor::using('fmap');
        $extract = Functor::using('extract');

        $maybeGetValueAtIndex = Maybe::using('maybeGetValueAtIndex');

        $thing = ['test', 'this'];

        $this->assertEquals(
            'this',
            $extract($maybeGetValueAtIndex(1, $thing))
        );

        $this->assertEquals(
            null,
            $extract($maybeGetValueAtIndex(2, $thing))
        );
    }

    public function testMaybeGetPropertyOfObject()
    {
        $compose = Lambda::using('compose');
        $map = Functor::using('fmap');
        $extract = Functor::using('extract');
        $bind = Monad::using('bind');

        $maybeGetValueAtIndex = Maybe::using('maybeGetValueAtIndex');
        $maybeGetPropertyOfObject = Maybe::using('maybeGetPropertyOfObject');

        $that = new \stdClass();
        $that->value = 'well';
        $thing = ['test', $that];

        $getChained = $compose(
            $extract,
            $bind($maybeGetPropertyOfObject('value')),
            $maybeGetValueAtIndex(1)
        );

        $this->assertEquals(
            'well',
            $getChained($thing)
        );
    }
}