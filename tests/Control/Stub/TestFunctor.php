<?php

namespace Vector\Test\Control\Stub;

use Vector\Typeclass\Functor;

class TestFunctor implements Functor
{
    private function __construct()
    {
        // Do Nothing
    }

    public static function Make()
    {
        return new TestFunctor();
    }

    public function fmap(Callable $f)
    {
        return 7;
    }

    public function extract()
    {
        return 7;
    }
}
