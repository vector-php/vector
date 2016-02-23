<?php

namespace Vector\Core;

use Vector\Core\Exception\FunctionNotFoundException;

abstract class Module
{
    protected static $doNotCurry = ['curry'];

    protected static function curry(Callable $f, $appliedArgs = [])
    {
        if ($f instanceof \Closure) {
            $reflector = (new \ReflectionFunction($f));
        } else {
            $reflector = (new \ReflectionMethod($f[0], $f[1]));
        }

        $arity = $reflector->getNumberOfParameters();

        return function(...$suppliedArgs) use ($f, $appliedArgs, $arity) {
            $args = array_merge($appliedArgs, $suppliedArgs);

            if (count($args) >= $arity)
                return call_user_func_array($f, $args);
            else
                return self::curry($f, $args);
        };
    }

    /**
     * @param mixed
     * @return callable
     */
    public static function using(...$requestedFunctions)
    {
        $context = get_called_class();

        $fulfilledRequest = array_map(function($f) use ($context) {
            if (!method_exists($context, $f))
                throw new FunctionNotFoundException("Function $f not found in module $context");

            if ($context::$doNotCurry === true || (is_array($context::$doNotCurry) && in_array($f, $context::$doNotCurry))) {
                return function(...$args) use ($context, $f) {
                    return call_user_func_array([$context, $f], $args);
                };
            }
            else {
                return self::curry([$context, $f]);
            }
        }, $requestedFunctions);

        return count($fulfilledRequest) === 1
            ? $fulfilledRequest[0]
            : $fulfilledRequest;
    }
}
