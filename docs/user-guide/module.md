# The Vector Module

The Vector Module exists in the `Vector\Core` namespace, and every Vector module
exists as a subclass of the Module. `Module` provides loads of benefits transparently, and
strives to be as simple as possible to implement.

## What it Does

The primary benefit of `Module` is that it will automatically curry the functions placed
inside of it. This allows you to write your functions without worrying about manually
adding the breakpoints for currying, or worrying about closing over curried arguments -- You can
simply write your function as through it receives all of its arguments at once, and let `Module`
handle the rest.

The `Module` also provides mechanisms for memoization -- caching function calls for long-running
or expensive operations -- transparently and automatically.

A side benefit of `Module` is that it allows you to autoload your functions with Composer.
While later versions of PHP have namespaced functions, there is currently no way to autoload
them in Composer aside from using the `autoload.files` field in the `composer.json` file, which
loads the file on every request regardless of whether or not it's needed.

## Implementing Your Own Module

### Creating the Module

To implement your own `Module`, simply create a new class and extend `Vector\Core\Module`:

```php
class MyModule extends Vector\Core\Module
{
}
```

### Adding Functions

The Module will intercept function calls using the `__callStatic` magic method from PHP. Because of this though,
the name of your function can't match the name that you call from your code. We choose to adopt the magic method standard and
declare all of our functions with double underscores prefixed to their names.

```
class MyModule extends Vector\Core\Module
{
    protected static __myFunction($a, $b)
    {
        return $a . ' foo ' . $b;
    }
}
```

Recommended practice is to declare the functions in a module as `protected`. The functions _cannot_ be `private` because the parent class `Module` needs
to be able to access them. They _can_ be `public` however, but it's best not to provide a way to call your raw function without passing it through the
`Module` proxy.

### Enabling Memoization

Memoized functions store the result of their execution in a private context, and can then short circuit their execution and return their result
if called again with the same arguments. This is effectively free caching.

!!! Important
    Memoization assumes that your functions are pure. If your functions have side effects, those side effects will not execute again
    if you memoize the function causing them! Avoid side effects!

Memoization is disabled for new modules by default -- you must opt into it. To enable memoization for a single or multiple functions, override
the `$memoize` field on your module:

```
class MyModule extends Vector\Core\Module
{
    protected static $memoize = ['myFunction'];

    protected static __myFunction($a, $b)
    {
        return $a . ' foo ' . $b;
    }
}
```

Alternatively, to enable memoization for an entire module, set `$memoize` to `true`.

Notice how we declared the function in our `$memoize` list -- we do not include the double underscore prefix of the function name. The `Module`
takes care of interpreting that for us. Just list your function names with their display names, or the names you would use when using them.

### Disabling Currying

If you for some reason don't want your function to be curried, you can override the
`$doNotCurry` field on your module:

```
class MyModule extends Vector\Core\Module
{
    protected static $doNotCurry = ['myFunction'];

    protected static __myFunction($a, $b)
    {
        return $a . ' foo ' . $b;
    }
}
```

Alternatively, to disable currying for an entire module, set `$doNotCurry` to `true`.

Notice again that we don't include the double underscore in the `$doNotCurry` array.

Generally speaking you should never need to do this. This exists as a side effect of the internal
curry implementation and is exposed only for any edge cases where you might need it.
