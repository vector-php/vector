<?php

namespace Vector;

use Vector\Core\PreludeModule;

class Prelude extends PreludeModule
{
    private $export = [
        'Vector\Lib\ArrayList' => [
            'head',
            'tail',
            'init',
            'last',
            'map',
            'filter'
        ]
    ];
}
