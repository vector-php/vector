<?php

namespace Vector;

use Vector\Core\PreludeModule;

class Prelude extends PreludeModule
{
    private static $export = [
        'head' => ['Vector\Lib\ArrayList\Head', 'head']
    ];
}
