<?php

namespace Vector\Test\Control\Stub;

class TestInts extends TestMultipleTypeConstructor
{
    protected $a;
    protected $b;
    protected $c;

    public function __construct(int $a, int $b, int $c)
    {
        $this->a = $a;
        $this->b = $b;
        $this->c = $c;
    }
}
