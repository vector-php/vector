<?php

namespace Vector\Util;

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

    /**
     * @param ...$requestedFunctions
     * @return callable
     */
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
