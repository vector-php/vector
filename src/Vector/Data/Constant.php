<?php

namespace Vector\Data;

use Vector\Typeclass\MonadInterface;

class Constant implements MonadInterface
{
    private $heldValue;

    private function __construct($value)
    {
        $this->heldValue = $value;
    }

    public static function constant($a)
    {
        return new Constant($a);
    }

    public function fmap(Callable $f)
    {
        return $this;
    }

    public function extract()
    {
        return $this->heldValue;
    }

    public static function pure($a)
    {
        return self::Constant($a);
    }

    public function apply($a)
    {
        return $this;
    }

    public function bind(Callable $f)
    {
        return $this;
    }
}
