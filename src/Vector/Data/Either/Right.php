<?php

namespace Vector\Data\Either;

/**
 * Class Right
 * @package Vector\Data\Either
 */
class Right extends Either
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }
//    protected static function __fromMaybe($leftValue, $maybeValue)
//    {
//        return Maybe::isJust($maybeValue)
//            ? Either::right(Maybe::extract($maybeValue))
//            : Either::left($leftValue);
//    }
}
