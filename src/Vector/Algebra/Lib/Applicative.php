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
}
