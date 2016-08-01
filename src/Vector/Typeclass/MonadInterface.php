<?php

namespace Vector\Typeclass;

interface MonadInterface extends ApplicativeInterface
{
    // bind :: Monad m => (a -> m b) -> m a -> m b
    public function bind(Callable $f);
}
