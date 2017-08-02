<?php

namespace Vector\Data;

use Exception;
use Vector\Control\Functor;
use Vector\Core\Module;
use Vector\Typeclass\MonadInterface;

/**
 * Class Maybe
 * @package Vector\Data
 * @method static callable just($value)
 * @method static callable nothing()
 */
abstract class Maybe extends Module implements MonadInterface
{
    // Constructors

    protected static function __just($value)
    {
        return new Just($value);
    }

    protected static function __nothing()
    {
        return new Nothing;
    }

    // Interface Contracts

    public function fmap(callable $f)
    {
        return $this instanceof Just
            ? self::just($f($this->extract()))
            : $this;
    }

    public static function pure($a)
    {
        return self::just($a);
    }

    public function apply($a)
    {
        return $this instanceof Just
            ? Functor::fmap($this->extract(), $a)
            : $this;
    }

    public function bind(callable $f)
    {
        return $this instanceof Just
            ? $f($this->extract())
            : $this;
    }

    // Maybe Methods

    public function isJust()
    {
        return $this instanceof Just;
    }

    public function isNothing()
    {
        return ! $this->isJust();
    }
}
