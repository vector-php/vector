<?php

namespace Vector\Typeclass;

/**
 * Trait IsMonad
 */
trait IsMonad
{
    /**
     * @param callable $f
     * @return mixed
     */
    public function bind(callable $f)
    {
        return $f(...$this->extract());
    }
}
