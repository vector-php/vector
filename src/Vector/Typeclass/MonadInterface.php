<?php

namespace Vector\Typeclass;

/**
 * Interface MonadInterface
 * @package Vector\Typeclass
 */
interface MonadInterface extends ApplicativeInterface
{
    /**
     * bind :: Monad m => (a -> m b) -> m a -> m b
     * @param callable $f
     * @return mixed
     */
    public function bind(Callable $f);
}
