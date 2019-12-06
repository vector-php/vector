<?php

namespace Vector\Typeclass;

interface FunctorInterface
{
    public function fmap(callable $f);
    public function extract();
}
