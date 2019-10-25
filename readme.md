![Vector Core](./logo.png)
[![Badge Status](https://img.shields.io/badge/badge%20status-dank-brightgreen.svg)](https://niceme.me/)

## The Elevator Pitch
Vector gives you php functional superpowers.
- The evolution:
    - `array_map(fn($a) => $a + 1, [1, 2, 3])` (_Native PHP_)
    - `collect([1, 2, 3])->map(fn($a) => $a + 1)` (_Laravel Collections_)
    - `Arrays::map(fn($a) => $a + 1)([1, 2, 3])` (_Vector_)

- You can add currying to any function, it isn't only limited to Vector built ins.
    - `Module::curry('explode')(',')('a,b,c')(PHP_INT_MAX)` `// ['a', 'b', 'c']`

- Create functional pipelines as first class citizens
    - `Lambda::pipe(Math::add(4), Math::add(2))(1)` `// 7`

## PHP Version Support
- 7.4+

## Install
```
composer require vector/core
```

## Show Me Some More Code

More automatic currying.
```php
$addOne = Arrays::map(Math::add(1));
$addOne([1, 2, 3]); // [2, 3, 4]
```

First class composition (Functional Pipelines).
```php
$addSix = Lambda::compose(Math::add(4), Math::add(2)); // (Or ::pipe for the opposite flow direction)
$addSix(4); // 10;
```

Pattern Matching.
```php
Pattern::match([
    fn(Just $value) => $unwrapped,
    fn(Nothing $value) => 'nothing',
])(Maybe::just('just')); // 'just'
```

Granular control flow (without try/catch).
```php
$errorHandler = function (Err $err) {
    return Pattern::match([
        function (QueryException $exception) {
            Log::info($exception);
            return response(404);
        },
        function (DBException $exception) {
            Log::error($exception);
            return response(500);
        },
    ]);
};

return Pattern::match([
    fn(Ok $value) => $user,
    $errorHandler
])(Result::from(fn() => User::findOrFail(1)));
```
