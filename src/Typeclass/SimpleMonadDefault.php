<?php

namespace Vector\Typeclass;

trait SimpleMonadDefault
{
    public function bind(callable $f)
    {
        return $f(...$this->extract());
    }
}
