<?php

namespace Vector\Data;

use Vector\Control\Functor;
use Vector\Core\Module;
use Vector\Typeclass\MonadInterface;

/**
 * Class Maybe
 * @package Vector\Data
 */
class Maybe extends Module implements MonadInterface
{
    private $heldValue;
    private $isJust;

    private function __construct($value, $isJust)
    {
        $this->heldValue = $value;
        $this->isJust = $isJust;
    }

    // Constructors

    protected static function __just($value)
    {
        return new Maybe($value, true);
    }

    protected static function __nothing()
    {
        return new Maybe(null, false);
    }

    // Interface Contracts

    public function fmap(callable $f)
    {
        return $this->isJust
            ? self::just($f($this->heldValue))
            : $this;
    }

    public static function pure($a)
    {
        return self::just($a);
    }

    public function apply($a)
    {
        return $this->isJust
            ? Functor::fmap($this->heldValue, $a)
            : $this;
    }

    public function bind(callable $f)
    {
        return $this->isJust
            ? $f($this->heldValue)
            : $this;
    }

    // Maybe Methods

    protected static function __extract()
    {
        return $this->isJust
            ? $this->heldValue
            : null;
    }
}
