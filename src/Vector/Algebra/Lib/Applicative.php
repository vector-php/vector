<?php

namespace Vector\Algebra\Lib;

use Vector\Util\FunctionCapsule;
use Vector\Algebra\Typeclass\Applicative;

abstract class Applicative extends FunctionCapsule
{
    protected static function pure($context, $a)
    {
        return call_user_func_array([$context, 'pure'], [$a]);
    }
     
    protected static function apply(Applicative $f, Applicative $a)
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
