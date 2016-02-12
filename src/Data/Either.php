<?php

namespace Vector\Data;

use Vector\Typeclass\Monad;

class Either implements Monad
{
    private $isRight = true;
    private $heldValue;

    private function __construct($value, $isRight)
    {
        $this->heldValue = $value;
        $this->isRight   = $isRight;
    }

    /*
     * Constructor Methods (Static)
     \ --- */

    // Left :: a -> Left a
    public static function left($value)
    {
        return new Either($value, false);
    }

    // Right :: a -> Right a
    public static function right($value)
    {
        return new Either($value, true);
    }

    /*
     * Functor Instance
     \ --- */

    // fmap :: Either f => (a -> b) -> f a -> f b
    public function fmap(Callable $f)
    {
        if ($this->isRight) {
            return self::Right($f($this->heldValue));
        }

        return $this;
    }

    public function extract()
    {
        return $this->heldValue;
    }

    /*
     * Applicative Instance
     \ --- */

    // pure :: Either f => a -> f a
    public static function pure($a)
    {
        return self::Right($a);
    }

    // apply :: Either f => f (a -> b) -> f a -> f b
    public function apply($a)
    {
        if ($this->isRight) {
            // Applicative a => apply (Either f) (a) === fmap f a
            return $a->fmap($this->heldValue);
        }

        return $this;
    }

    /*
     * Monad Instances
     \ --- */

    // bind :: Either m => (a -> m b) -> m a -> m b
    public function bind(Callable $f)
    {
        if ($this->isRight) {
            return $f($this->heldValue);
        }

        return $this;
    }
}
