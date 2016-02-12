<?php

namespace Vector\Data;

use Vector\Typeclass\Monad;

class Constant implements Monad
{
    private $heldValue;

    private function __construct($value)
    {
        $this->heldValue = $value;
    }

    /*
     * Constructor Methods (Static)
     \ --- */

    public static function constant($a)
    {
        return new Constant($a);
    }

    /*
     * Functor Instance
     \ --- */

    public function fmap(Callable $f)
    {
        return $this;
    }

    /*
     * Applicative Instance
     \ --- */

    public static function pure($a)
    {
        return self::Constant($a);
    }

    public function apply($a)
    {
        return $this;
    }

    /*
     * Monad Instances
     \ --- */

    public function bind(Callable $f)
    {
        return $this;
    }

    public function extract()
    {
        return $this->heldValue;
    }
}
