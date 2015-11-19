<?php

namespace Vector\Algebra\Lambda;

use Vector\Algebra\Typeclass\Functor;
use Vector\Algebra\Typeclass\Monad;

function curry(Callable $f, $appliedArgs = [])
{
    $arity = (new \ReflectionFunction($f))->getNumberOfParameters();
    
    return function(...$suppliedArgs) use ($f, $appliedArgs, $arity) {
        $args = array_merge($appliedArgs, $suppliedArgs);
        
        if (count($args) === $arity)
            return call_user_func_array($f, $args);
        else
            return curry($f, $args);
    };
}

function pipe(...$fs)
{
    return function(...$args) use ($fs) {
        $carry = null;
        
        foreach ($fs as $f)
            $carry = $carry ? $f($carry) : $f(...$args);
        
        return $carry;
    };
}

function compose(...$fs)
{
    return pipe(...array_reverse($fs));
}

function fmap(...$args)
{
    // Functor f => Callable (a -> b) -> f a -> f b
    $fmap = curry(function(Callable $f, Functor $container) {
        return $container->fmap($f);
    });
    
    return $fmap(...$args);
}

function bind(...$args)
{
    // Monad m => Callable (a -> m b) -> m a -> m b
    $bind = curry(function(Callable $f, Monad $container) {
        return $container->bind($f);
    });
    
    return $bind(...$args);
}
