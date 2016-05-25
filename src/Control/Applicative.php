<?php

namespace Vector\Control;

use Vector\Core\Module;

abstract class Applicative extends Module
{
    protected static function pure($context, $a)
    {
        if (is_array($context)) {
            return [$a];
        }

        return call_user_func_array([$context, 'pure'], [$a]);
    }

    protected static function apply($f, $a)
    {
        if (is_array($f) && is_array($a)) {
            $crossProduct = [];

            foreach ($f as $fs) {
                foreach ($a as $as) {
                    $crossProduct[] = $fs($as);
                }
            }

            return $crossProduct;
        }

        return $f->apply($a);
    }

    protected static function liftA2($instance, $f, $a1, $a2)
    {
        list($pure, $apply) = self::using('pure', 'apply');

        return $apply(
            $apply(
                $pure($instance, $f),
                $a1
            ),
            $a2
        );
    }

    protected static function liftA3($instance, $f, $a1, $a2, $a3)
    {
        list($pure, $apply) = self::using('pure', 'apply');

        return $apply(
            $apply(
                $apply(
                    $pure($instance, $f),
                    $a1
                ),
                $a2
            ),
            $a3
        );
    }
}
