<?php

namespace Vector\Control;

use Vector\Core\FunctionCapsule;
use Vector\Typeclass\ApplicativeInterface as TypeclassApplicative;

abstract class Applicative extends FunctionCapsule
{
    protected static function pure($context, $a)
    {
        return call_user_func_array([$context, 'pure'], [$a]);
    }

    protected static function apply(TypeclassApplicative $f, TypeclassApplicative $a)
    {
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
}
