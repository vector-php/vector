
## _all

__All__ :: array -> Bool



Returns true given all values are truthy

```
$all(1, 'asdf', true); // True
$all(1, false); // False
```

Parameter | Type | Description
-|-|-
$arr | array | Values to test
return | Bool | are all values truthy


---

## _any

__Any__ :: array -> Bool



Returns true given any values are truthy

```
$any(true, false); // True
$any(false, false); // False
```

Parameter | Type | Description
-|-|-
$arr | array | Values to test
return | Bool | are any values truthy


---

## _eq

__Equal (Not Strict / ==)__ :: mixed -> mixed -> Bool



Returns true given $a equals $b

```
$eq(1, 1); // True
$eq(1, 2); // False
```

Parameter | Type | Description
-|-|-
$a | mixed | First value
$b | mixed | Second value
return | Bool | is $a equal to $b


---

## _eqStrict

__Equal (Strict / ===)__ :: mixed -> mixed -> Bool



Returns true given $a equals $b

```
$eq(1, 1); // True
$eq(1, '1'); // False
```

Parameter | Type | Description
-|-|-
$a | mixed | First value
$b | mixed | Second value
return | Bool | is $a equal to $b


---

## _gt

__Greater Than__ :: mixed -> mixed -> Bool



Returns true given $b is greater than $a.

```
$gt(2, 1); // False
$gt(1, 2); // True
```

Parameter | Type | Description
-|-|-
$a | mixed | Value
$b | mixed | Value to test
return | Bool | is $b greater than $a


---

## _gte

__Greater Than Or Equal__ :: mixed -> mixed -> Bool



Returns true given $b is greater than or equal to $a.

```
$gte(1, 1); // True
$gte(1, 2); // True
```

Parameter | Type | Description
-|-|-
$a | mixed | Value
$b | mixed | Value to test
return | Bool | is $b greater than or equal to $a


---

## _logicalAnd

__Logical And__ :: Bool -> Bool -> Bool



Returns true given $a AND $b are true.

```
$logicalAnd(true, true); // True
$logicalAnd(true, false); // False
```

Parameter | Type | Description
-|-|-
$a | mixed | First value
$b | mixed | Second value
return | Bool | Result of AND


---

## _logicalNot

__Logical Not__ :: Bool -> Bool



Returns true given $a is false.
Returns false given $a is true.

```
$logicalNot(true); // False
$logicalNot(false); // True
```

Parameter | Type | Description
-|-|-
$a | mixed | value
return | Bool | Result of NOT


---

## _logicalOr

__Logical Or__ :: Bool -> Bool -> Bool



Returns true given $a OR $b returns true.

```
$logicalOr(true, false); // True
$logicalOr(false, false); // False
```

Parameter | Type | Description
-|-|-
$a | mixed | First value
$b | mixed | Second value
return | Bool | Result of OR


---

## _lt

__Less Than__ :: mixed -> mixed -> Bool



Returns true given $b is less than $a.

```
$lt(2, 1); // True
$lt(1, 2); // False
```

Parameter | Type | Description
-|-|-
$a | mixed | Value
$b | mixed | Value to test
return | Bool | is $b less than $a


---

## _lte

__Less Than Or Equal__ :: mixed -> mixed -> Bool



Returns true given $b is less than or equal to $a.

```
$lte(1, 1); // True
$lte(2, 1); // True
```

Parameter | Type | Description
-|-|-
$a | mixed | Value
$b | mixed | Value to test
return | Bool | is $b less than or equal to $a


---

## _not

__Logical Not__ :: Bool -> Bool



Returns the inverse of $a

```
$not(false); // true
```

Parameter | Type | Description
-|-|-
$a | bool | Value to invert
return | bool | Inverted value


---

## _notEq

__Not Equal (Not Strict / ==)__ :: mixed -> mixed -> Bool



Returns true given $a does not equal $b

```
$notEq(1, 1); // False
$notEq(1, 2); // True
```

Parameter | Type | Description
-|-|-
$a | mixed | First value
$b | mixed | Second value
return | Bool | is $a not equal to $b


---

## _notEqStrict

__Not Equal (Strict / ===)__ :: mixed -> mixed -> Bool



Returns true given $a does not equal $b

```
$notEqStrict(1, 2); // True
$notEqStrict(1, '1'); // False
```

Parameter | Type | Description
-|-|-
$a | mixed | First value
$b | mixed | Second value
return | Bool | is $a not equal to $b


---

## _orCombinator

__Logical Or Combinator__ :: [(a -> Bool)] -> a -> Bool



Given two functions f and g, combine them in such a way to produce a new
function h that returns true given f(x) OR g(x) returns true.

```
$funcF = function($x) { return $x >= 5; };
$funcG = function($x) { return $x == 0; };

$combinator = $orCombinator([$funcF, $funcG]);

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
