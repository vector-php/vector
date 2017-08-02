<?php

namespace Vector\Data;

use Exception;

/**
 * Class Just
 * @package Vector\Data
 */
class Just extends Maybe
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function extract()
    {
        if ($this->isNothing()) {
            throw new Exception('cannot extract nothing');
        }

        return $this->value;
    }
}
