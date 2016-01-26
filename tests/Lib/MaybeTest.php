<?php

namespace Vector\Test\Lib;

use Vector\Control\Functor;
use Vector\Control\Monad;

use Vector\Lib\Lambda;
use Vector\Lib\Maybe;

use Vector\Data\Maybe as MaybeMonad;

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
