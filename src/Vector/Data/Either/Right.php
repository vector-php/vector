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
}
