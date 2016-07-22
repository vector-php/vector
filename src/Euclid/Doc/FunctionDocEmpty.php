<?php

namespace Vector\Euclid\Doc;

use Reflector;

class FunctionDocEmpty
{
    private $reflector;

    public function __construct(Reflector $reflector)
    {
        $this->reflector = $reflector;
    }

    public function properName()
    {
        return substr($this->reflector->name, 2);
    }

    public function emptyDocMessage()
    {
        return 'This function is currently missing documentation.';
    }
}
