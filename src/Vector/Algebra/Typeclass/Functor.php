<?php

namespace Vector\Algebra\Typeclass;

interface Functor
{
    // fmap :: Functor f => (a -> b) -> f a -> f b
    public function fmap(Callable $f);

    public function extract();
}
