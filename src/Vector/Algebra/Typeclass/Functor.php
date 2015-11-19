<?php

namespace Vector\Algebra\Typeclass;

interface Functor
{
    public function fmap(Callable $f);
}
