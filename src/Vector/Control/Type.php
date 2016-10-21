<?php

namespace Vector\Control;

use Vector\Core\Module;

/**
 * Class Type
 * @package Vector\Control
 */
class Type extends Module
{
    protected static function __string($value)
    {
        return is_string($value);
    }

    protected static function __int($value)
    {
        return is_int($value);
    }

    protected static function __number($value)
    {
        return is_numeric($value);
    }

    protected static function __float($value)
    {
        return is_float($value);
    }

    protected static function __bool($value)
    {
        return is_bool($value);
    }

    protected static function __object($value)
    {
        return is_object($value);
    }

    protected static function __array($value)
    {
        return is_array($value);
    }

    protected static function __null($value)
    {
        return is_null($value);
    }
}
