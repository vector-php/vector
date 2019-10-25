<?php

namespace Vector\Test\Control\Stub;

class TestIntsAndString extends TestMultipleTypeConstructor
{
    protected $a;
    protected $b;
    protected $str;

    public function __construct(int $a, int $b, string $str)
    {
        $this->a = $a;
        $this->b = $b;
        $this->str = $str;
    }
}
