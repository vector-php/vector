<?php

namespace Vector\Core;

use Vector\Core\Exception\FunctionNotFoundException;

abstract class Module
{
    /**
     * An array of functions on this module to memoize automatically
     * @var array
     */
    protected static $memoize = [];

    /**
     * A memoized cache of all the function requests fulfilled by this module
     * @var array
     */
    protected static $fulfillmentCache = [];

    /**
     * An array of function names to NOT curry when being fulfilled from the 'using' method
     * @var array
     */
    protected static $doNotCurry = ['curry'];

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
     * $head = ArrayList::head();
     * $head([1, 2, 3]); // 1
     * ```
     *
     * @param  string $name Name of the function to call
     * @param  mixed  $args Arguments to pass to the function
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
     * $myCurriedFunction(1); // Callable
     * $myCurriedFunction(1)(1); // 2, PHP7 Only
     * ```
     *
     * @type (* -> *) -> * -> *
     *
     * @param  Callable $f Function to curry
     * @return Callable    The result of currying the original function.
     */
    protected static function __curry(Callable $f)
    {
        // Curry a function of unknown arity
        return self::curryWithArity($f, self::getArity($f));
    }

    /**
     * Curry a function with a specific arity. This is used internally
     * to curry functions that accept variadic arguments, e.g. for memoized functions.
     *
     * @param  Callable $f           Function to curry
     * @param  Int      $arity       Arity of $f
     * @param  array    $appliedArgs The arguments already applied to the curried function. This
     *                               argument is for internal use only.
     * @return Callable              The result of currying the original function.
     */
    private static function curryWithArity(Callable $f, $arity, $appliedArgs = [])
    {
        // Return a new function where we use the arguments already closed over,
        // and merge them with the arguments we get from the new function.
        return function(...$suppliedArgs) use ($f, $appliedArgs, $arity) {
            $args = array_merge($appliedArgs, $suppliedArgs);

            // If we have enough arguments, apply them to the internally curried function
            // closed over from the original function call.
            if (count($args) >= $arity)
                return call_user_func_array($f, $args);
            // Otherwise, recursively call curry again, passing in the arguments supplied
            // from this call
            else
                return self::curryWithArity($f, $arity, $args);
        };
    }

    /**
     * Memoize a Function
     *
     * Provided a function $f, return a new function that keeps track of all calls to
     * $f and caches their responses. Good for functions that have long-running execution times.
     * Bad for functions that have side effects. But you don't write those now do you?
     *
     * ```
     * $myFastFunction = $memoize($myBigFunction);
     *
     * $myFastFunction(1, 2); // Really long wait
     * $myFastFunction(1, 2); // Instantaneous response
     * ```
     *
     * @type (* -> *) -> * -> *
     *
     * @param  Callable $f Function to memoize
     * @return Callable    Memoized funciton $f
     */
    private static function memoize(Callable $f)
    {
        return function(...$args) use ($f) {
            static $cache;

            if ($cache === null)
                $cache = [];

            $key = serialize($args);

            if (array_key_exists($key, $cache)) {
                return $cache[$key];
            } else {
                $result = call_user_func_array($f, $args);
                $cache[$key] = $result;

                return $result;
            }
        };
    }

    /**
     * Function Arity
     *
     * Returns the arity of a funciton, e.g. the number of arguments it
     * expects to recieve before it returns a value.
     *
     * @param  Callable $f Function to get arity for
     * @return Int         Number of arguments for $f
     */
    private static function getArity(Callable $f)
    {
        if ($f instanceof \Closure) {
            $reflector = (new \ReflectionFunction($f));
        } else {
            $reflector = (new \ReflectionMethod($f[0], $f[1]));
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
     * $myFunc = MyModule::using('myFunc'); // Callable
     * list($foo, $bar) = MyModule::using('foo', 'bar'); // $foo = Callable, $bar = Callable
     * ```
     *
     * @type String -> (* -> *)
     *
     * @param  array    $requestedFunctions Variadic list of strings, function names to request
     * @return callable                     A single callable, or an array of callable representing
     *                                      the fulfilled request for functions from the module
     */
    public static function using(...$requestedFunctions)
    {
        $context = get_called_class();

        $fulfilledRequest = array_map(function($f) use ($context) {
            // Append a '__' to the name we're looking for
            $internalName = '__' . $f;

            // See if we've already fulfilled the request for this function. If so, just return the cached one.
            if (array_key_exists($context, self::$fulfillmentCache) && array_key_exists($internalName, self::$fulfillmentCache[$context]))
                return self::$fulfillmentCache[$context][$internalName];

            // If we haven't fulfilled it already, check to see if it even exists
            if (!method_exists($context, $internalName))
                throw new FunctionNotFoundException("Function $f not found in module $context");

            // Check to see if we're memoizing this function, or the whole module. Otherwise, carry on.
            if ($context::$memoize === true || in_array($f, $context::$memoize)) {
                $functionInContext = self::memoize([$context, $internalName]);
            }
            else
                $functionInContext = [$context, $internalName];

            // If the function exists, then see if we're supposed to curry it. If not, just return it in a closure.
            if ($context::$doNotCurry === true || (is_array($context::$doNotCurry) && in_array($f, $context::$doNotCurry))) {
                $fulfillment = function(...$args) use ($functionInContext) {
                    return call_user_func_array($functionInContext, $args);
                };
            }
            // Otherwise, curry it
            else
                $fulfillment = self::curryWithArity($functionInContext, self::getArity([$context, $internalName]));

            // Then store it in our cache so we can short circuit this process in the future
            self::$fulfillmentCache[$context][$internalName] = $fulfillment;

            // And return it
            return $fulfillment;
        }, $requestedFunctions);

        // If only one function was requested, return it. Otherwise keep it in an array for list() to work.
        return count($fulfilledRequest) === 1
            ? $fulfilledRequest[0]
            : $fulfilledRequest;
    }

    /**
     * Bulk Module Loading
     *
     * Uses reflection to bulk-load every function in a module and place it into a key/value array. The key
     * is the function name as it is defined in the module.
     * The result of this method call can be used in the PHP function `explode` to place an entire
     * module into the local scope without the boilerplate of loading functions individually if you need
     * many functions from a single module.
     *
     * ```
     * extract(MyModule::usingAll()); // Lots of new functions in the scope
     * ```
     *
     * @type [(* -> *)]
     *
     * @return array A key/value array of function names and actual curried callable
     */
    public static function usingAll()
    {
        $context     = get_called_class();
        $isInContext = function(\ReflectionMethod $m) use ($context) {
            return $m->getDeclaringClass()->getName() === $context;
        };

        // The names of the functions we're requesting, sans the inherited Module methods
        $fNames = array_map(function(\ReflectionMethod $f) use ($context) {
            $fName = $f->getName();

            // Check for the full method name
            $fName = substr($fName, 2);

            return $fName;
        }, array_filter((new \ReflectionClass($context))->getMethods(), $isInContext));

        // The actual functions we're using pulled from the module
        $fValues = array_map(function($f) {
            return self::using($f);
        }, $fNames);

        // Return the fulfilled functions in a key/value array for extract() to work
        return array_combine($fNames, $fValues);
    }
}
