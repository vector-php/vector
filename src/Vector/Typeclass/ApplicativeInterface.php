<?php

namespace Vector\Typeclass;

interface ApplicativeInterface extends FunctorInterface
{
    // pure :: Applicative f => a -> f a
    public static function pure($a);

    // apply :: Applicative f => f (a -> b) -> f a -> f b
    public function apply($a);
}
