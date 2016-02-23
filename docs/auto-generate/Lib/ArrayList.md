
## concat

> [a] -> [a] -> [a]

__Array Concatenation__



Joins two arrays together, with the second argument being appended
to the end of the first. Defers to php build-in function `array_merge`,
so repeated keys will be overwritten.

```
$concat([1, 2], [2, 3]); // [1, 2, 2, 3]
$concat(['a' => 1, 'b' => 2], ['a' => 'foo', 'c' => 3]); // ['a' => 'foo', 'b' => 2, 'c' => 3]
```

---

## filter

> (a -> Bool) -> [a] -> [a]

__Filter a List__



Returns a filtered list. Given a function that takes an element and returns
either true or false, return a list of all the elements
of the input list that pass the test.

!!! Note
    'filter' preserves the keys of a key/value array - it only looks at values

```
$filter(function($a) { return $a > 2; }, [1, 2, 3, 4, 5]); // [3, 4, 5], using an inline function
$filter(function($a) { return $a > 2; }, ['foo' => 1, 'bar' => 3]); // ['foo' => 1]
$filter($lte(2), [1, 2, 3, 4, 5]); // [1, 2], using $lte from the Math module
```

---

## head

> [a] -> a

__List Head__


!!! Warning
    Throws Vector\Core\Exception\EmptyListException if argument is empty list


Returns the first element of a list, the element at index 0. Also functions
properly for key/value arrays, e.g. arrays whose first element may not necessarily
be index 0. If an empty array is given, head throws an Exception.

```
$head([1, 2, 3]); // 1
$head(['a' => 1, 'b' => 2]); // 1
$head([]); // Exception thrown
```

---

## index

> Int -> [a] -> a

__List Index__


!!! Warning
    Throws Vector\Core\Exception\IndexOutOfBoundsException if the requested index does not exist


Returns the element of a list at the given index. Throws an exception
if the given index does not exist in the list.

```
$index(0, [1, 2, 3]); // 1
$index('foo', ['bar' => 1, 'foo' => 2]); // 2
$index('baz', [1, 2, 3]); // Exception thrown
```

---

## init

> [a] -> [a]

__Initial List Values__



Returns an array without its last element, e.g. the inverse of `tail`. Works on
key/value arrays as well as 'regular' arrays. If an empty or single-value array is given,
returns an empty array.

```
$init([1, 2, 3]); // [1, 2]
$init(['a' => 1, 'b' => 2]); // ['a' => 1];
```

---

## keys

> [a] -> [b]

__Array Keys__



Returns the keys of an associative key/value array. Returns numerical indeces
for non key/value arrays.

```
$keys(['a' => 1, 'b' => 2]); // ['a', 'b']
$keys([1, 2, 3]); // [0, 1, 2]
```

---

## last

> [a] -> a

__Last List Value__


!!! Warning
    Throws Vector\Core\Exception\EmptyListException if argument is empty list


Returns the last element of an array, e.g. the complement of `init`. Works on key/value
arrays as well as 'regular' arrays. If an empty array is given, throws an exception.

```
$last([1, 2, 3]); // 3
$last(['a' => 1, 'b' => 2]); // 2
$last([]); // Exception thrown
```

---

## length

> [a] -> a

__Array Length__



Returns the length of a list or array. Wraps php `count` function.

```
$length([1, 2, 3]); // 3
$length(['a' => 1, 'b' => 2]); // 2
```

---

## maybeIndex

> Int -> a -> Maybe a

__Maybe List Index__



Returns the element of a list at the given index, or nothing. Is safe to call
if you don't know if an index exists. If the index does not exist, returns `Nothing`.
Otherwise returns `Just a`.

```
$index(0, [1, 2, 3]); // Just 1
$index('foo', ['bar' => 1, 'foo' => 2]); // Just 2
$index('baz', [1, 2, 3]); // Nothing - (No exception thrown)
```

---

## set

> a -> [b] -> b -> [b]

__Set Array Value__



Sets the value of an array at the given index; works for non-numerical indeces.
The value is set in an immutable way, so the original array is not modified.

```
$set(0, 'foo', [1, 2, 3]); // ['foo', 2, 3]
$set('c', 3, ['a' => 1, 'b' => 2]); // ['a' => 1, 'b' => 2, 'c' => 3]
```

---

## tail

> [a] -> [a]

__List Tail__



Returns an array without its first element, e.g. the complement of `head`. Works on
key/value arrays as well as 'regular' arrays. If an empty array of an array of one element
is given, returns an empty array.

```
$tail([1, 2, 3]); // [2, 3]
$tail(['a' => 1, 'b' => 2]); // ['b' => 2];
```

---

## values

> [a] -> [a]

__Array Values__



Returns the values of an associative key/value array.

```
$values(['a' => 1, 'b' => 2]); // [1, 2]
$values([1, 2, 3]); // [1, 2, 3]
```

---
