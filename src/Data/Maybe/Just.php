<?php

namespace Vector\Data\Maybe;

class Just extends Maybe
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }
}
