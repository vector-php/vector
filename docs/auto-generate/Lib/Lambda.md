
## _compose

__No Summary Given__ :: No Type Signature Provided



No Description Given. Make an issue referencing this function's lack of
                documentation on <a href="https://github.com/joseph-walker/vector">Github</a>.



---

## _flip

__Flip Combinator__ :: (a -> b -> c) -> b -> a -> c



Given a function that takes two arguments, return a new function that
takes those two arguments with their order reversed.

```
$subtract(2, 6); // 4
$flip($subtract)(2, 6); // -4
```

Parameter | Type | Description
-|-|-
$f | \Closure | Function to flip
return | \Closure | Flipped function


---

## _id

__Identity Function__ :: a -> a



Given some value a, return a unchanged

```
$id(4); // 4
$id('foo'); // 'foo'
```

Parameter | Type | Description
-|-|-
$a | mixed | Value to return
return | mixed | The given value, unchanged


---

## _k

__K Combinator__ :: a -> (b -> a)



Given some value k, return a lambda expression which always evaluates to k, regardless
of any arguments it is given.

```
$alwaysFour = $k(4);

$alwaysFour('foo'); // 4
$alwaysFour(1, 2, 3); // 4
$alwaysFour(); // 4
```

Parameter | Type | Description
-|-|-
$k | mixed | Value to express in the combinator
return | \Closure | Expression which always returns $k


---

## _pipe

__No Summary Given__ :: No Type Signature Provided



No Description Given. Make an issue referencing this function's lack of
                documentation on <a href="https://github.com/joseph-walker/vector">Github</a>.



---
