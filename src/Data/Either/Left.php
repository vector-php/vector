<?php

namespace Vector\Data\Either;

use Vector\Control\Functor;

/**
 * Class Left
 * @package Vector\Data\Either
 */
class Left extends Either
{
    protected $error;

    protected function __construct($error)
    {
        $this->error = $error;
    }
//    protected static function __fromMaybe($leftValue, $maybeValue)
//    {
//        return Maybe::isJust($maybeValue)
//            ? Either::right(Maybe::extract($maybeValue))
//            : Either::left($leftValue);
//    }
}
