<?php

namespace Vector\Lib;

use Vector\Core\FunctionCapsule;
use Vector\Data\Maybe as MaybeMonad;

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
