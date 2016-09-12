<?php

namespace Vector\Typeclass;

/**
 * Interface FunctorInterface
 * @package Vector\Typeclass
 */
interface FunctorInterface
{
    /**
     * fmap :: Functor f => (a -> b) -> f a -> f b
     * @param callable $f
     * @return mixed
     */
    public function fmap(callable $f);
}
