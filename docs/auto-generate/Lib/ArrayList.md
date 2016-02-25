
## concat

__Array Concatenation__ :: [a] -> [a] -> [a]



Joins two arrays together, with the second argument being appended
to the end of the first. Defers to php build-in function `array_merge`,
so repeated keys will be overwritten.

```
$concat([1, 2], [2, 3]); // [1, 2, 2, 3]
$concat(['a' => 1, 'b' => 2], ['a' => 'foo', 'c' => 3]); // ['a' => 'foo', 'b' => 2, 'c' => 3]
```

Parameter | Type | Description
-|-|-
$a | Array | Array $a List to be appended to
$b | Array | Array $b List to append
return | Array | Array    Concatenated list of $a and $b


---

## filter

__Filter a List__ :: (a -> Bool) -> [a] -> [a]



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

Parameter | Type | Description
-|-|-
$f | Callable | Callable $f   Test function - should take an `a` and return a Bool
$arr | Array | Array    $arr List to filter
return | Array | Array         Result of filtering the list


---

## head

__List Head__ :: [a] -> a


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

Parameter | Type | Description
-|-|-
$list | Array | Array $list Key/Value array or List
return | Mixed | Mixed       First element of $list


---

## index

__List Index__ :: Int -> [a] -> a


!!! Warning
    Throws Vector\Core\Exception\IndexOutOfBoundsException if the requested index does not exist


Returns the element of a list at the given index. Throws an exception
if the given index does not exist in the list.

```
$index(0, [1, 2, 3]); // 1
$index('foo', ['bar' => 1, 'foo' => 2]); // 2
$index('baz', [1, 2, 3]); // Exception thrown
```

Parameter | Type | Description
-|-|-
$i | Int | Int   $i    Index to get
$list | Array | Array $list List to get index from
return | Mixed | Mixed       Item from $list and index $i


---

## init

__Initial List Values__ :: [a] -> [a]



Returns an array without its last element, e.g. the inverse of `tail`. Works on
key/value arrays as well as 'regular' arrays. If an empty or single-value array is given,
returns an empty array.

```
$init([1, 2, 3]); // [1, 2]
$init(['a' => 1, 'b' => 2]); // ['a' => 1];
```

Parameter | Type | Description
-|-|-
$list | Array | Array $list Key/Value array or List
return | Array | Array       $list without the last element


---

## keys

__Array Keys__ :: [a] -> [b]



Returns the keys of an associative key/value array. Returns numerical indeces
for non key/value arrays.

```
$keys(['a' => 1, 'b' => 2]); // ['a', 'b']
$keys([1, 2, 3]); // [0, 1, 2]
```

Parameter | Type | Description
-|-|-
$arr | Array | Array $arr List to get keys from
return | Array | Array      The keys of $arr


---

## last

__Last List Value__ :: [a] -> a


!!! Warning
    Throws Vector\Core\Exception\EmptyListException if argument is empty list


Returns the last element of an array, e.g. the complement of `init`. Works on key/value
arrays as well as 'regular' arrays. If an empty array is given, throws an exception.

```
$last([1, 2, 3]); // 3
$last(['a' => 1, 'b' => 2]); // 2
$last([]); // Exception thrown
```

Parameter | Type | Description
-|-|-
$list | Array | Array $list Key/Value array or List
return | Mixed | Mixed       The last element of $list


---

## length

__Array Length__ :: [a] -> a



Returns the length of a list or array. Wraps php `count` function.

```
$length([1, 2, 3]); // 3
$length(['a' => 1, 'b' => 2]); // 2
```

Parameter | Type | Description
-|-|-
$list | Array | Array $list Key/Value array or List
return | Int | Int         Length of $list


---

## maybeIndex

__Maybe List Index__ :: Int -> a -> Maybe a



Returns the element of a list at the given index, or nothing. Is safe to call
if you don't know if an index exists. If the index does not exist, returns `Nothing`.
Otherwise returns `Just a`.

```
$index(0, [1, 2, 3]); // Just 1
$index('foo', ['bar' => 1, 'foo' => 2]); // Just 2
$index('baz', [1, 2, 3]); // Nothing - (No exception thrown)
```

Parameter | Type | Description
-|-|-
$i | Int | Int   $i    Index to get
$list | Mixed | Mixed $list List to get index from
return | \Maybe | Maybe       Item from $list and index $i


---

## set

__Set Array Value__ :: a -> [b] -> b -> [b]



Sets the value of an array at the given index; works for non-numerical indexes.
The value is set in an immutable way, so the original array is not modified.

```
$set(0, 'foo', [1, 2, 3]); // ['foo', 2, 3]
$set('c', 3, ['a' => 1, 'b' => 2]); // ['a' => 1, 'b' => 2, 'c' => 3]
```

Parameter | Type | Description
-|-|-
$key | Mixed | Mixed $key Element of index to modify
$arr | Array | Array $arr Array to modify
$val | Mixed | Mixed $val Value to set $arr[$key] to
return | Array | Array      Result of setting $arr[$key] = $val


---

## tail

__List Tail__ :: [a] -> [a]



Returns an array without its first element, e.g. the complement of `head`. Works on
key/value arrays as well as 'regular' arrays. If an empty array of an array of one element
is given, returns an empty array.

```
$tail([1, 2, 3]); // [2, 3]
$tail(['a' => 1, 'b' => 2]); // ['b' => 2];
```

Parameter | Type | Description
-|-|-
$list | Array | Array $list Key/Value array or List
return | Array | Array       $list without the first element


---

## values

__Array Values__ :: [a] -> [a]



Returns the values of an associative key/value array.

```
$values(['a' => 1, 'b' => 2]); // [1, 2]
$values([1, 2, 3]); // [1, 2, 3]
```

Parameter | Type | Description
-|-|-
$arr | Array | Array $arr Key/Value array
return | Array | Array      Indexed array with values of $arr


---

## zipWith

__Custom Array Zip__ :: (a -> b -> c) -> [a] -> [b] -> [c]



Given two arrays a and b, and some combinator f, combine the arrays using the combinator
f(ai, bi) into a new array c. If a and b are not the same length, the resultant array will
always be the same length as the shorter array, i.e. the zip stops when it runs out of pairs.

```
$combinator = function($a, $b) { return $a + $b; };
$zipWith($combinator, [1, 2, 3], [0, 8, -1]); // [1, 10, 2]
$zipWith($combinator, [0], [1, 2, 3]); // [1]
```

Parameter | Type | Description
-|-|-
$f | Callable | Callable $f The function used to combine $a and $b
$a | Array | Array    $a The first array to use in the combinator
$b | Array | Array    $b The second array to use in the combinator
return | Array | Array       The result of calling f with each element of a and b in series


---
