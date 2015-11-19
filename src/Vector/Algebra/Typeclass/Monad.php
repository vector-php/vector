<?php

namespace Vector\Algebra\Typeclass;

use Vector\Algebra\Typeclass\Applicative;

interface Monad extends Applicative
{
    // bind :: Monad m => (a -> m b) -> m a -> m b
    public function bind(Callable $f);
}
