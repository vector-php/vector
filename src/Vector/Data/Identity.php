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

    public static function identity($a)
    {
        return new Identity($a);
    }

    public function fmap(Callable $f)
    {
        return self::Identity($f($this->heldValue));
    }

    public static function pure($a)
    {
        return self::Identity($a);
    }

    public function apply($a)
    {
        // Identity a => apply (Identity f) (a) === fmap f a
        return $a->fmap($this->heldValue);
    }

    public function bind(Callable $f)
    {
        return $f($this->heldValue);
    }

    public function extract()
    {
        return $this->heldValue;
    }
}
