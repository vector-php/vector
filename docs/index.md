# Vector / Core

## Purpose
Vector gives your functions superpowers.
It lets you autoload your functions with Composer without having to mess with autload files.
It allows you to automatically curry your userland functions with zero effort on your part.
It provides built-in memoization for abstracting away time-consuming pure operations.
It gives you useful helpers for composing simple functions into more complex ones and gives you the building blocks you need to make data manipulation easier than ever, all while maintaining a simple and declarative module loading system so your dependencies are always clear and concise.

## PHP Version Support
- 5.6 +

## Show Me Some Code
Autoloading Functions? No problem.
```
use Vector\Lib\ArrayList;
```

Currying? No problem.
```
$addOne = ArrayList::map(function($a) { return $a + 1; });
$addOne([1, 2, 3]); // [2, 3, 4]
```

Memoization? No problem.
```
Class MyFunctions extends Module {
    protected $memoize = ['myFunction'];
}
```

Composition? No problem;
```
$addSix = Lambda::compose(Math::add(4), Math::add(2));
$addSix(4); // 10;
```
