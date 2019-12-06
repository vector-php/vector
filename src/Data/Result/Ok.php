<?php

namespace Vector\Data\Result;

class Ok extends Result
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }
}
