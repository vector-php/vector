<?php

namespace Vector\Data\Maybe;

/**
 * Class Just
 * @package Vector\Data
 */
class Just extends Maybe
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }
}
