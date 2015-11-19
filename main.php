<?php

namespace Vector\Algebra\Lambda;

abstract class FunctionCapsule
{
    private static function curry(Callable $f, $appliedArgs = [])
    {
        $arity = (new \ReflectionMethod($f[0], $f[1]))->getNumberOfParameters();
        
        return function(...$suppliedArgs) use ($f, $appliedArgs, $arity) {
            $args = array_merge($appliedArgs, $suppliedArgs);
            
            // TODO: Testing >= arity as opposed to == 
            // is a hack to support currying of variadic
            // functions. I have no idea if this works in every 
            // situation - it needs to be more rigorously tested
            if (count($args) >= $arity)
                return call_user_func_array($f, $args);
            else
                return self::curry($f, $args);
        };
    }
    
    public static function using(...$requestedFunctions)
    {
        $context = get_called_class();
        
        $fulfilledRequest = array_map(function($f) use ($context) {
            return self::curry([$context, $f]);
        }, $requestedFunctions);
        
        return count($fulfilledRequest) === 1 
            ? $fulfilledRequest[0] 
            : $fulfilledRequest;
    }
}

abstract class Lambda extends FunctionCapsule
{    
    protected static function compose(...$a)
    {
        return "Composed Implementation";
    }
}

abstract class Functor extends FunctionCapsule
{
    protected static function fmap($f, $container)
    {
        return $container->fmap($f);
    }
}

abstract class Baz extends FunctionCapsule
{
    protected static function foo($a)
    {
        return $a + 1;
    }
    
    protected static function bar($a, $b, $c)
    {
        return $a + $b * $c;
    }
}

$compose         = Lambda::using('compose');
$fmap            = Functor::using('fmap');
list($foo, $bar) = Baz::using('foo', 'bar');
