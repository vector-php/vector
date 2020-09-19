<?php

namespace Vector\Control;

use Vector\Lib\Lambda;

class Vector
{
    private $value;
    private $functions = [];

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function pipe(callable $function): Vector
    {
        array_push($this->functions, $function);

        return $this;
    }

    public function __invoke()
    {
        return Lambda::pipe(...$this->functions)($this->value);
    }
}
