<?php

require __DIR__ . '/vendor/autoload.php';

/**
 * @method int add(int $a, int $b) Add two numbers
 */
class Test extends Vector\Core\Module
{
    private static function add($a, $b)
    {
        return call_user_func_array(self::curry(function($a, $b) {
            return $a + $b;
        }), [$a, $b]);
    }
}
