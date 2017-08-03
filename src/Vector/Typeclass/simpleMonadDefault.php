<?php

namespace Vector\Typeclass;

/**
 * Trait IsMonad
 */
trait simpleMonadDefault
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
