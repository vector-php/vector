<?php

namespace Vector\Control;

use Vector\Core\Module;

/**
 * Class Type
 * @package Vector\Control
 * @method static bool string() string($value) check if value is a string
 * @method static bool int() int($value) check if value is an int
 * @method static bool number() number($value) check if value is a number
 * @method static bool float() float($value) check if value is a float
 * @method static bool bool() bool($value) check if value is a bool
 * @method static bool object() object($value) check if value is an object
 * @method static bool array() array($value) check if value is an array
 * @method static bool null() null($value) check if value is null
 */
class Type extends Module
{
    /**
     * @param $value
     * @return bool
     */
    protected static function __string($value) : bool
    {
        return is_string($value);
    }

    /**
     * @param $value
     * @return bool
     */
    protected static function __int($value) : bool
    {
        return is_int($value);
    }

    /**
     * @param $value
     * @return bool
     */
    protected static function __number($value) : bool
    {
        return is_numeric($value);
    }

    /**
     * @param $value
     * @return bool
     */
    protected static function __float($value) : bool
    {
        return is_float($value);
    }

    /**
     * @param $value
     * @return bool
     */
    protected static function __bool($value) : bool
    {
        return is_bool($value);
    }

    /**
     * @param $value
     * @return bool
     */
    protected static function __object($value) : bool
    {
        return is_object($value);
    }

    /**
     * @param $value
     * @return bool
     */
    protected static function __array($value) : bool
    {
        return is_array($value);
    }

    /**
     * @param $value
     * @return bool
     */
    protected static function __null($value) : bool
    {
        return is_null($value);
    }
}
