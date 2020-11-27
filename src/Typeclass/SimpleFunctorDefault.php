<?php

namespace Vector\Typeclass;

trait SimpleFunctorDefault
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function extract()
    {
        return $this->value;
    }
}
