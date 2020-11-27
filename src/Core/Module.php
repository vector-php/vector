<?php

namespace Vector\Core;

use Closure;
use ReflectionFunction;
use ReflectionMethod;
use ReflectionAttribute;
use Vector\Core\Exception\FunctionNotFoundException;

trait Module
{
    public static function __callStatic($name, $args)
    {
        // Check if it has the curry attribute
        $reflectionMethod = new ReflectionMethod(self::class, $name);
        $attributes = $reflectionMethod->getAttributes(
            Curry::class,
            ReflectionAttribute::IS_INSTANCEOF
        );

        if (!empty($attributes) && $reflectionMethod->isProtected()) {
            return call_user_func_array(self::using($name), $args);
        }

        $bt = debug_backtrace();
        $caller = array_shift($bt);
        throw new FunctionNotFoundException(
            "\n"
            . "Attempted to call non-curried method: "
            . self::class
            . '::'
            . $name
            . "\n"
            . $caller['file']
            . ': on line '
            . $caller['line']
            . "\n\n"
        );
    }

    /**
     * Function Curry
     *
     * Given some callable f, curry it so that its arguments can be applied in chunks.
     * Functions fulfilled from a module's 'using' method are automatically passed
     * through this function, unless they are listed out in a particular module's
     * 'doNotCurry' list.
     *
     * ```
     * $myFunction = function($a, $b) {
     *     return $a + $b;
     * };
     *
     * $myCurriedFunction = $curry($myFunction);
     * $myCurriedFunction(1); // callable
     * $myCurriedFunction(1)(1); // 2, PHP7 Only
     * ```
     *
     * @type (* -> *) -> * -> *
     *
     * @param callable $f Function to curry
     * @return callable    The result of currying the original function.
     * @throws \ReflectionException
     */
    public static function curry(callable $f)
    {
        // Curry a function of unknown arity
        return self::curryWithArity($f, self::getArity($f));
    }

    /**
     * Curry a function with a specific arity. This is used internally
     * to curry functions that accept variadic arguments, e.g. for memoized functions.
     *
     * @param callable $f Function to curry
     * @param Int $arity Arity of $f
     * @param array $appliedArgs The arguments already applied to the curried function. This
     *                               argument is for internal use only.
     * @return callable              The result of currying the original function.
     */
    protected static function curryWithArity(callable $f, $arity, $appliedArgs = [])
    {
        // Return a new function where we use the arguments already closed over,
        // and merge them with the arguments we get from the new function.
        return function (...$suppliedArgs) use ($f, $appliedArgs, $arity) {
            $args = array_merge($appliedArgs, $suppliedArgs);

            // If we have enough arguments, apply them to the internally curried function
            // closed over from the original function call.
            if (count($args) >= $arity) {
                return call_user_func_array($f, $args);
            } else {
                // Otherwise, recursively call curry again, passing in the arguments supplied
                // from this call
                return self::curryWithArity($f, $arity, $args);
            }
        };
    }

    /**
     * Function Arity
     *
     * Returns the arity of a funciton, e.g. the number of arguments it
     * expects to recieve before it returns a value.
     *
     * @param callable $f Function to get arity for
     * @return Int         Number of arguments for $f
     * @throws \ReflectionException
     */
    protected static function getArity(callable $f)
    {
        if (is_string($f) || $f instanceof Closure) {
            $reflector = (new ReflectionFunction($f));
        } else {
            $reflector = (new ReflectionMethod($f[0], $f[1]));
        }

        // Count the number of arguments the function is asking for
        return $reflector->getNumberOfParameters();
    }

    /**
     * Module Loading
     *
     * Provided some function name, load that function into a callable from the definition.
     * The function is automatically curried unless it is listed in that module's doNotCurry list.
     * If `using` is passed multiple function names, they are returned in an array so they can be
     * split apart using PHP's internal `list` function.
     *
     * ```
     * $myFunc = MyModule::using('myFunc'); // callable
     * list($foo, $bar) = MyModule::using('foo', 'bar'); // $foo = callable, $bar = callable
     * ```
     *
     * @type String -> (* -> *)
     *
     * @param array $requestedFunctions Variadic list of strings, function names to request
     * @return callable                     A single callable, or an array of callable representing
     *                                      the fulfilled request for functions from the module
     */
    public static function using(...$requestedFunctions)
    {
        $context = get_called_class();

        $fulfilledRequest = array_map(function ($f) use ($context) {
            // Append a '__' to the name we're looking for
//            $internalName = '__' . $f;
            $internalName = $f;

            // If we haven't fulfilled it already, check to see if it even exists
            if (! method_exists($context, $internalName)) {
                throw new FunctionNotFoundException("Function {$f} not found in module {$context}");
            }

            $functionInContext = [$context, $internalName];

            // curry the function
            return self::curryWithArity($functionInContext, self::getArity([$context, $internalName]));
        }, $requestedFunctions);

        // If only one function was requested, return it. Otherwise keep it in an array for list() to work.
        return count($fulfilledRequest) === 1
            ? $fulfilledRequest[0]
            : $fulfilledRequest;
    }
}
