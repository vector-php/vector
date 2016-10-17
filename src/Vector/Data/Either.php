<?php

namespace Vector\Data;

use Vector\Control\Functor;
use Vector\Core\Module;
use Vector\Typeclass\MonadInterface;

/**
 * Class Either
 * @package Vector\Data
 */
class Either extends Module implements MonadInterface
{
    private $heldValue;
    private $isRight;

    private function __construct($value, $isRight)
    {
        $this->heldValue = $value;
        $this->isRight = $isRight;
    }

    // Constructors

    protected static function __left($value)
    {
        return new Either($value, false);
    }

    protected static function __right($value)
    {
        return new Either($value, true);
    }

    // Interface Contracts

    public function fmap(callable $f)
    {
        return $this->isRight
            ? self::right($f($this->heldValue))
            : $this;
    }

    public static function pure($a)
    {
        return self::right($a);
    }

    public function apply($a)
    {
        return $this->isRight
            ? Functor::fmap($this->heldValue, $a)
            : $this;
    }

    public function bind(callable $f)
    {
        return $this->isRight
            ? $f($this->heldValue)
            : $this;
    }

    public function getHeldValue()
    {
        return $this->heldValue;
    }

    // Either Methods

    protected static function __extract($eitherValue)
    {
        return $eitherValue->getHeldValue();
    }

    protected static function __fromMaybe($leftValue, $maybeValue)
    {
        return Maybe::isJust($maybeValue)
            ? Either::right(Maybe::extract($maybeValue))
            : Either::left($leftValue);
    }
}
