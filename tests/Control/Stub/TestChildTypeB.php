<?php

namespace Vector\Test\Control\Stub;

/**
 * Class TestChildTypeB
 * @package Vector\Test\Control\Stub
 */
class TestChildTypeB extends TestParentType
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
