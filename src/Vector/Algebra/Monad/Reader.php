<?php

namespace Vector\Algebra\Monad;

use Vector\Algebra\Typeclass\Monad;

class Reader implements Monad
{
    private $heldFunction;

    private function __construct($value)
    {
        $this->heldFunction = $value;
    }

    public function run($context)
    {
        return call_user_func_array($this->heldFunction, [$context]);
    }

    /*
     * Constructor Methods (Static)
     \ --- */

    public static function Reader($value)
    {
        return new Reader($value);
    }

    /*
     * Functor Instance
     \ --- */

    // fmap :: Reader f => (a -> b) -> f a -> f b
    public function fmap(Callable $f)
    {

    }

    public function extract()
    {

    }

    /*
     * Applicative Instance
     \ --- */

    // pure :: Reader f => a -> f a
    public static function pure($a)
    {
        return new Reader(function() use ($a) {
            return $a;
        });
    }

    // apply :: Reader f => f (a -> b) -> f a -> f b
    public function apply($a)
    {

    }

    /*
     * Monad Instances
     \ --- */

    // bind :: Reader m => (a -> m b) -> m a -> m b
    public function bind(Callable $k)
    {
        return new Reader(function($r) use ($k) {
            return $k($this->run($r))->run($r);
        });
    }
}