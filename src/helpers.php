<?php

use Vector\Control\Vector;

if (! function_exists('vector')) {
    function vector($value)
    {
        return new Vector($value);
    }
}
