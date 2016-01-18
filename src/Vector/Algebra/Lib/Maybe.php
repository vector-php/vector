<?php

namespace Vector\Algebra\Lib;

use Vector\Util\FunctionCapsule;
use Vector\Algebra\Monad\Maybe as MaybeMonad;

class Maybe extends FunctionCapsule
{
    protected static function maybeGetValueAtIndex($index, $array) {
        return isset($array[$index])
            ? MaybeMonad::Just($array[$index])
            : MaybeMonad::Nothing();
    }

    protected static function maybeGetPropertyOfObject($property, $object) {
        return property_exists($object, $property)
            ? MaybeMonad::Just($object->{$property})
            : MaybeMonad::Nothing();
    }
}