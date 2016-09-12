<?php

namespace Vector\Control;

use Vector\Core\Module;

/**
 * Class Applicative
 * @package Vector\Control
 */
abstract class Applicative extends Module
{
    /**
     * @param $context
     * @param $a
     * @return array|mixed
     */
    protected static function __pure($context, $a)
    {
        if (is_array($context)) {
            return [$a];
        }

        return call_user_func_array([$context, 'pure'], [$a]);
    }

    /**
     * @param $f
     * @param $a
     * @return array
     */
    protected static function __apply($f, $a)
    {
        if (is_array($f) && is_array($a)) {
            $crossProduct = [];

            foreach ($f as $fs) {
                foreach ($a as $as) {
                    $crossProduct[] = $fs($as);
                }
            }

            return $crossProduct;
        } else {
            return $f->apply($a);
        }
    }

    /**
     * @param $instance
     * @param $f
     * @param $a1
     * @param $a2
     * @return mixed
     */
    protected static function __liftA2($instance, $f, $a1, $a2)
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

    /**
     * @param $instance
     * @param $f
     * @param $a1
     * @param $a2
     * @param $a3
     * @return mixed
     */
    protected static function __liftA3($instance, $f, $a1, $a2, $a3)
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
