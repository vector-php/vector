<?php

namespace Vector\Data\Result;

class Err extends Result
{
    protected $err;

    public function __construct($err)
    {
        $this->err = $err;
    }
}
