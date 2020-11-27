<?php

namespace Vector\Data\Maybe;

use Vector\Typeclass\SimpleFunctorDefault;

class Just extends Maybe
{
    use SimpleFunctorDefault;

    public function __construct($value)
    {
        $this->value = $value;
    }
}
