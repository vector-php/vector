<?php

namespace Vector\Core;

use Vector\Core\Exception\FunctionNotFoundException;

abstract class Module
{
    /**
     * This flag globally sets a module to append an underscore when it proxies a function
     * call through the __callStatic magic method. This is so that dumb PHP IDEs can keep up with
     * what we're throwing down and allow us to override @method tags in a class doc.
     *
     * When this flag is enabled, you MUST append an underscore (_) to every function you declare
     * on your module, or else it will not be found when accessing it through the magic __callStatic method.
     *
     * This flag only affects the internal naming of your functions. You still access your functions through
     * their un-appended name. E.g. you will still use Lambda::compose() or Lambda::using('compose').
     *
     * @var boolean
     */
    protected static $dirtyHackToEnableIDEAutocompletion = false;

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
     * @type (* -> *) -> (* -> *)
     *
     * @param  Callable $f           Function to curry
     * @param  array    $appliedArgs The arguments already applied to the curried function. This
     *                               argument is for internal use only.
     * @return Callable              The result of currying the original function.
     */
    protected static function curry(Callable $f, $appliedArgs = [])
    {
        if ($f instanceof \Closure) {
            $reflector = (new \ReflectionFunction($f));
        } else {
            $reflector = (new \ReflectionMethod($f[0], $f[1]));
        }

        // Count the number of arguments the function is asking for
        $arity = $reflector->getNumberOfParameters();

        // Then return a new function where we use the arguments already closed over,
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
                return self::curry($f, $args);
        };
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
            // If we're using the dirty hack for IDE autocomplete, append an '_' to the name we're looking for
            if ($context::$dirtyHackToEnableIDEAutocompletion === true)
                $f = '_' . $f;

            // See if we've already fulfilled the request for this function. If so, just return the cached one.
            if (array_key_exists($context, self::$fulfillmentCache) && array_key_exists($f, self::$fulfillmentCache[$context]))
                return self::$fulfillmentCache[$context][$f];

            // If we haven't fulfilled it already, check to see if it even exists
            if (!method_exists($context, $f))
                throw new FunctionNotFoundException("Function $f not found in module $context");

            // If it does, then see if we're supposed to curry it. If not, just return it in a closure.
            if ($context::$doNotCurry === true || (is_array($context::$doNotCurry) && in_array($f, $context::$doNotCurry))) {
                $fulfillment = function(...$args) use ($context, $f) {
                    return call_user_func_array([$context, $f], $args);
                };
            }
            // Otherwise, curry it
            else
                $fulfillment = self::curry([$context, $f]);

            // Then store it in our cache so we can short circuit this process in the future
            self::$fulfillmentCache[$context][$f] = $fulfillment;

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

            // Check for the dirty hack
            if ($context::$dirtyHackToEnableIDEAutocompletion === true)
                $fName = substr($fName, 1);

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
