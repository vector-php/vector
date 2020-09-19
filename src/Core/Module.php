<?php

namespace Vector\Core;

use Closure;
use ReflectionFunction;
use ReflectionMethod;
use Vector\Core\Exception\FunctionNotFoundException;

/**
 * @method static callable curry(...$args)
 */
trait Module
{
    /**
     * Alternative Module Loading
     *
     * By utilizing the __callStatic magic method to intercept static method calls, we can
     * proxy those calls off to the ::using() method of the module to make the functions in the
     * module act like standard static PHP methods. The result is a more natural way of calling
     * Vector functions that is more akin to native PHP.
     *
     * Invoking the function with no arguments results in a closure that is identical to
     * requesting the function through a ::using() call.
     *
     * ```
     * $increment = Math::add(1);
     * $increment(5); // 6
     *
     * $head = Arrays::head();
     * $head([1, 2, 3]); // 1
     * ```
     *
     * @param string $name Name of the function to call
     * @param mixed $args Arguments to pass to the function
     * @return mixed        Result of proxying off to the requested function
     */
    public static function __callStatic($name, $args)
    {
        return call_user_func_array(self::using($name), $args);
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
    protected static function __curry(callable $f)
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
            $internalName = '__' . $f;

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
