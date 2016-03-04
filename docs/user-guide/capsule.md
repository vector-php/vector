# The Vector Module

The Vector Module exists in the `Vector\Core` namespace, and every Vector module
exists as a subclass of the Module. `Module` provides loads of benefits, and
strives to be as simple as possible to implement.

## What it Does

The primary benefit of `Module` is that it will automatically curry the functions placed
inside of it. This allows you to write your functions without worrying about manually
adding the breakpoints for currying, or worrying about closing over curried arguments -- You can
simply write your function as through it receives all of its arguments at once, and let `Module`
handle the rest.

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

To add functions to your new module, declare them as `protected static`:

```
class MyModule extends Vector\Core\Module
{
    protected static myFunction($a, $b)
    {
        return $a . ' foo ' . $b;
    }
}
```

Note that the functions in your module _MUST_ be declared as `protected` if you want
to use the alternative function invocation pattern - When you call
to the methods on the module using `MyModule::myFunction()`, the `__callStatic` magic method
intercepts the call in order to provide currying by proxying your request. If your function is not `protected`, the magic
method is not called as the request is deferred to the public method definition, and `Module`
_CANNOT_ curry your function for you.

### Disabling Currying

If you for some reason don't want your function to be curried, you can override the
`$doNotCurry` field on your module:

```
class MyModule extends Vector\Core\Module
{
    protected static $doNotCurry = ['myFunction'];

    protected static myFunction($a, $b)
    {
        return $a . ' foo ' . $b;
    }
}
```

Generally speaking you should never need to do this. This exists as a side effect of the internal
curry implementation and is exposed only for any edge cases where you might need it.
