<?php

namespace Vector\Test\Control\Stub;

class TestChildTypeA extends TestParentType
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function extract()
    {
        return $this->value;
    }
}
