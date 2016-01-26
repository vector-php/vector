<?php

namespace Vector\Core;

abstract class FunctionCapsule
{
    protected static $doNotCurry = false;

    protected static function curry(Callable $f, $appliedArgs = [])
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
     * @param mixed
     * @return callable
     */
    public static function using(...$requestedFunctions)
    {
        $context = get_called_class();

        $fulfilledRequest = array_map(function($f) use ($context) {
            if ($context::$doNotCurry) {
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
