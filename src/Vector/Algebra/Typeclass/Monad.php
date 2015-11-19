<?php

namespace Vector\Algebra\Typeclass;

use Vector\Algebra\Typeclass\Functor;

interface Monad extends Functor
{
    public function pure($a);
    public function bind(Callable $f);
}
