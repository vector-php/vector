## all[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Logic.php#L341)

__All__ :: array -> Bool

Returns true given all values are truthy

```
Logic::all(1, 'asdf', true); // True
Logic::all(1, false); // False
```

---

## andCombinator[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Logic.php#L76)

__Logical And Combinator__ :: [(a -> Bool)] -> a -> Bool

Given n functions {f1, f2, ..., fn}, combine them in such a way to produce a new
function g that returns true given {f1(x), f2(x), ... fn(x)} all return true.

```
$funcF = function($x) { return $x < 5; };
$funcG = function($x) { return $x > 0; };
$combinator = Logic::andCombinator([$funcF, $funcG]);
$combinator(4); // True
$combinator(2); // True
$combinator(7); // False
```

---

## any[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Logic.php#L363)

__Any__ :: array -> Bool

Returns true given any values are truthy

```
Logic::any(true, false); // True
Logic::any(false, false); // False
```

---

## eq[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Logic.php#L254)

__Equal (Not Strict / ==)__ :: mixed -> mixed -> Bool

Returns true given $a equals $b

```
Logic::eq(1, 1); // True
Logic::eq(1, 2); // False
```

---

## eqStrict[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Logic.php#L276)

__Equal (Strict / ===)__ :: mixed -> mixed -> Bool

Returns true given $a equals $b

```
Logic::eqStrict(1, 1); // True
Logic::eqStrict(1, '1'); // False
```

---

## gt[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Logic.php#L166)

__Greater Than__ :: mixed -> mixed -> Bool

Returns true given $b is greater than $a.

```
Logic::gt(2, 1); // False
Logic::gt(1, 2); // True
```

---

## gte[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Logic.php#L188)

__Greater Than Or Equal__ :: mixed -> mixed -> Bool

Returns true given $b is greater than or equal to $a.

```
Logic::gte(1, 1); // True
Logic::gte(1, 2); // True
```

---

## logicalAnd[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Logic.php#L144)

__Logical And__ :: Bool -> Bool -> Bool

Returns true given $a AND $b are true.

```
Logic::logicalAnd(true, true); // True
Logic::logicalAnd(true, false); // False
```

---

## logicalNot[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Logic.php#L122)

__Logical Not__ :: Bool -> Bool

Returns true given $a is false.
Returns false given $a is true.

```
Logic::logicalNot(true); // False
Logic::logicalNot(false); // True
```

---

## logicalOr[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Logic.php#L100)

__Logical Or__ :: Bool -> Bool -> Bool

Returns true given $a OR $b returns true.

```
Logic::logicalOr(true, false); // True
Logic::logicalOr(false, false); // False
```

---

## lt[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Logic.php#L210)

__Less Than__ :: mixed -> mixed -> Bool

Returns true given $b is less than $a.

```
Logic::lt(2, 1); // True
Logic::lt(1, 2); // False
```

---

## lte[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Logic.php#L232)

__Less Than Or Equal__ :: mixed -> mixed -> Bool

Returns true given $b is less than or equal to $a.

```
Logic::lte(1, 1); // True
Logic::lte(2, 1); // True
```

---

## notEq[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Logic.php#L298)

__Not Equal (Not Strict / ==)__ :: mixed -> mixed -> Bool

Returns true given $a does not equal $b

```
Logic::notEq(1, 1); // False
Logic::notEq(1, 2); // True
```

---

## notEqStrict[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Logic.php#L320)

__Not Equal (Strict / ===)__ :: mixed -> mixed -> Bool

Returns true given $a does not equal $b

```
Logic::notEqStrict(1, 2); // True
Logic::notEqStrict(1, '1'); // False
```

---

## orCombinator[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Logic.php#L49)

__Logical Or Combinator__ :: [(a -> Bool)] -> a -> Bool

Given n functions {f1, f2, ..., fn}, combine them in such a way to produce a new
function g that returns true given at least one of {f1(x), f2(x), ... fn(x)} return true.

```
$funcF = function($x) { return $x >= 5; };
$funcG = function($x) { return $x == 0; };
$combinator = Logic::orCombinator([$funcF, $funcG]);
$combinator(9); // True
$combinator(0); // True
$combinator(2); // False
```

---

