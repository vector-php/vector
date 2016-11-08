# Functional Basics

First of all, what is functional programming?

> In computer science, functional programming is a programming paradigm that treats computation
> as the evaluation of mathematical functions and avoids changing-state and mutable data.

Vector is a functional programming library that follows this credo and implements helpers and utilities
that allow you to do the same in your own code.

Before we get started, here's some things to know:

### Function Declaration vs. Function Expression

You're probably very familiar with functions in PHP. But what you might not know is that there are
multiple ways to declare functions in PHP. The first is a declaration, where a function name is placed
into a function table keyed to its name and accessible globally (so long as it's loaded). The second method is
a function expression, where a function is placed into the PHP Closure object and stored in a scoped variable.

```php
// Function Declaration
function add($a, $b) {
    return $a + $b;
}

// Function Expression
$add = function($a, $b) {
    return $a + $b;
}
```

We can use a function expression in the same way we use a regular function:

```php
$add(1, 2); // Returns 3
```

Vector makes exclusive use of function expressions, both for consistency when combining functions together
and for their scoped nature.

### Using Vector Functions

Functions in Vector are organized into modules, which each have some related functionality or 'theme.' Simply call the function
you want to use as though it were a normal static function on the module in question.

For instance, if we want to use in the Vector wrapper function for `count` called `length` from the `Arrays` module, we would
write:

```php
Vector\Lib\Arrays::length([1, 2, 3]); // 3
```

If you look at the Arrays class in Vector\Lib, you'll notice that there is not actually a `length` function defined anywhere. Rather, there's a `__length`
function that looks something like this:

```php
protected static function __length($list)
{
    return count($list);
}
```
The function module intercepts calls to static functions on a module and performs a set of operations under the hood and completely transparently. We'll
go into more detail about how this is implemented, and more importantly, how you can implement your own modules in the 'Module' section.

It's important to note that calling a function on a module with no arguments will return a closure that executes the requested function
when invoked. For instance:

```php
$length = Vector\Lib\Arrays::length();
$length([1, 2, 3]); // 3
```

At first this may seem strange, but it's actually both intended and useful -- and a direct consequence of currying, which will we discuss next.

## Currying

Currying is the act of modifying a function in such a way that it can accept its arguments in chunks. A curried function
doesn't have to be supplied all of its arguments in order to have some effect.

Say we have a function that adds two numbers together.

```php
$add = function($a, $b) {
    return $a + $b;
}
```

When we want to use add, we have to supply it two arguments, `$a` and `$b`. But say we want to give it is first argument,
go do something else, then come back and give it its second argument. We can curry the `$add` function to allow us to do this.

```php
$addCurried = function($a) {
    return function($b) use ($a) {
        return $a + $b;
    }
}
```

Now we can use the `$add` function like this:

```php
$addNow = $addCurried(1); // $addNow = curried PHP closure
$addLater = $addNow(2);   // $addLater = 3;
```

Why in the world would we ever want to do this? Currying in and of itself doesn't give us much,
but it has a powerful consequence: Partial Application.

## Partial Application

Notice in the previous example how we stored the interim result of giving the first argument to our curried `$add` function in a local variable
called `$addNow`. This variable is a function expression, and it can be used in the same way as any other function. The first argument we've given
it has been closed over, and this is now a completely new function with different behaviors from `$add`. Let's rename it to `$increment` and see how it behaves:

```php
$increment = $addCurried(1);

$increment(2); // 3
$increment(0); // 1
$increment(9); // 10
```

We've taken our `$add` function and created an increment function, without writing a single line of code aside from applying the first argument. We can create an infinite
number of `$addX` functions in exactly the same way.

All functions in Vector are curried by default, so they can all be partially applied. This is why calling a Vector function with no arguments returns that function as a closure
as we discussed in the __Using Vector Functions__ section.

## Composition

We've now seen how we can create functions from other functions by partially applying them. But there are other ways to create new functions from small components.
We can also compose them together, which is like creating a chain of steps for a function to step through, from beginning to end.

Vector provides a `compose` function in the Lambda module which we can pull in and play around with. `compose` takes its arguments and applies them sequentially from
back to front -- provided every argument is a function.

Let's say we want to create a function that converts from celcius to fahrenheit, and that we've already implmented the basic mathematical functions like
add, subtract, multiply, and divide. We can use `compose` to chain all these calculations together to create a `toFahrenheit` function:

```php
// Let's assume we have an $add and $multiply function. The Math module
// provies these, but we'll just assume we have them in locally scoped closure objects.

// Notice that compose returns a function.
// In PHP 7+ you can invoke it immediately using Lambda::compose(...)($arg)
$toFahrenheit = Lambda::compose(
    $add(32),
    $multiply(9/5)
);

$toFahrenheit(8); // Returns 46.4
```

Notice how `compose` reads: We first perform the operation last in the list, then move backward to the front of the list. This is laid out to match the mathematical definition
of compose: `(f ∘ g)(x) = f(g(x))`. If you can't wrap your head around the backwards nature, Vector also supplied a `pipe` function on the Lambda module that acts as compose
from front-to-back.

Notice also how we used partial application to create helper functions from `$add` and `$multiply`. Partial application and composition
can be mixed and matched to create more complex functions from very simple components.

## Lifting

Let's use our `$toFahrenheit` function from before, but imagine instead that we want to apply it to a list of temperatures. Instead of looping over the
list in a procedural way, let's use `map` from the Arrays module.

```php
// Our list of temperatures
$data = [50.0, 176.0, 212.0];

Arrays::map($toFahrenheit, $data); // Returns [10, 80, 100]
```

If you've ever used PHP's `array_map` before, you should recognize what's going on. `map` is taking a function with one input and one output, and sequentially
applying it to every element in an array.

However, `map` is a function just like any other - it's curried, and it can be partially applied. If we partially apply `map`, we've created a new function that now operates
on a list as opposed to a single element. We've lifted it from one domain to another. Let's see how we can use this in conjunction with partial application and composition, putting
it all together.

Say we have a set of temperature data from a weather API, but it's not the highest quality -- The values it gives us are one degree lower than they should be.
Our task is to calculate the mean temperature from the temperature data after correcting the values by shifting
them one degree higher.

```php
// The Math module provides a mean function, and we're using $add and $toFahrenheit from above
$correctedMeanTemp = Lambda::compose(
    Math::mean(),
    Arrays::map(
        Lambda::compose($toFahrenheit, $add(1))
    )
);
```

Notice how we have created a function to complete our task without even bothering to load our data in - we don't need it. Our function will first
add one to every element in the dataset and then convert it to fahrenheit, then pass that mapped array to our mean function. This is called the point-free style.

Now we can take our `$correctedMeanTemp` and add it to our own Vector module and use it throughout our codebase whenever we need to work with temperature data.

In the next section, we'll go over the Vector Module - how it works, and how you can make your own.
