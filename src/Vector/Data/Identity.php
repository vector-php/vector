<?php

namespace Vector\Data;

use Vector\Typeclass\MonadInterface;

class Identity implements MonadInterface
{
    private $heldValue;

    private function __construct($value)
    {
        $this->heldValue = $value;
    }

    /*
     * Constructor Methods (Static)
     \ --- */

    // Identity :: a -> Identity a
    public static function identity($a)
    {
        return new Identity($a);
    }

    /*
     * Functor Instance
     \ --- */

    // fmap :: Identity f => (a -> b) -> f a -> f b
    public function fmap(Callable $f)
    {
        return self::Identity($f($this->heldValue));
    }

    /*
     * Applicative Instance
     \ --- */

    // pure :: Identity f => a -> f a
    public static function pure($a)
    {
        return self::Identity($a);
    }

    // apply :: Identity f => f (a -> b) -> f a -> f b
    public function apply($a)
    {
        // Identity a => apply (Identity f) (a) === fmap f a
        return $a->fmap($this->heldValue);
    }

    /*
     * Monad Instances
     \ --- */

    // bind :: Identity m => (a -> m b) -> m a -> m b
    public function bind(Callable $f)
    {
        return $f($this->heldValue);
    }

    public function extract()
    {
        return $this->heldValue;
    }
}
