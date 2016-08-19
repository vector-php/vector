<?php

namespace Vector\Typeclass;

interface FunctorInterface
{
    // fmap :: Functor f => (a -> b) -> f a -> f b
    public function fmap(Callable $f);
}
