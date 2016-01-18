<?php

namespace Vector\Algebra\Typeclass;

interface Monad extends Applicative
{
    // bind :: Monad m => (a -> m b) -> m a -> m b
    public function bind(Callable $f);
}
