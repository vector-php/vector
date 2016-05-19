
## eq

__No Summary Given__ :: No Type Signature Provided



No Description Given. Make an issue referencing this function's lack of
                documentation on <a href="https://github.com/joseph-walker/vector">Github</a>.



---

## gt

__No Summary Given__ :: No Type Signature Provided



No Description Given. Make an issue referencing this function's lack of
                documentation on <a href="https://github.com/joseph-walker/vector">Github</a>.



---

## logicalAnd

__No Summary Given__ :: No Type Signature Provided



No Description Given. Make an issue referencing this function's lack of
                documentation on <a href="https://github.com/joseph-walker/vector">Github</a>.



---

## logicalNot

__No Summary Given__ :: No Type Signature Provided



No Description Given. Make an issue referencing this function's lack of
                documentation on <a href="https://github.com/joseph-walker/vector">Github</a>.



---

## logicalOr

__No Summary Given__ :: No Type Signature Provided



No Description Given. Make an issue referencing this function's lack of
                documentation on <a href="https://github.com/joseph-walker/vector">Github</a>.



---

## orCombinator

__Logical Or Combinator__ :: (a -> Bool) -> (a -> Bool) -> (a -> Bool)



Given two functions f and g, combine them in such a way to produce a new
function h that returns true given f(x) OR g(x) returns true.

```
$funcF = function($x) { return $x >= 5; };
$funcG = function($x) { return $x == 0; };

$combinator = $orCombinator($funcF, $funcG);

$combinator(9); // True
$combinator(0); // True
$combinator(2); // False
```

Parameter | Type | Description
-|-|-
$f | callable | First function to combine
$g | callable | Second function to combine
return | \Closure | Result of f(x) or g(x)


---
