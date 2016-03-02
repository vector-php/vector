
## compose

__No Summary Given__ :: No Type Signature Provided



No Description Given



---

## id

__Identity Function__ :: a -> a



Given some value a, return a unchanged

```
$id(4); // 4
$id('foo'); // 'foo'
```

Parameter | Type | Description
-|-|-
$a | mixed | mixed $a Value to return
return | mixed | mixed    The given value, unchanged


---

## k

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
$k | mixed | mixed    $k Value to express in the combinator
return | \Closure | \Closure    Expression which always returns $k


---

## pipe

__No Summary Given__ :: No Type Signature Provided



No Description Given



---
