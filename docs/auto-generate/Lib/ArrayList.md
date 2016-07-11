
## _bifurcate

__Array Bifurcation__ :: (a -> Bool) -> [a] -> ([a], [a])



Given an array and some filtering test that returns a boolean, return two arrays - one array
of elements that pass the test, and another array of elements that don't. Similar to filter,
but returns the elements that fail as well.

```
$bifurcate($isEven, [1, 2, 3, 4, 5]); // [[2, 4], [1, 3, 5]]
```

Parameter | Type | Description
-|-|-
$test | callable | Test to use when bifurcating the array
$arr | array | Array to split apart
return | array | An array with two elements; the first is the list that passed the test,
                       and the second element is the list that failed the test


---

## _concat

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
$a | array | List to be appended to
$b | array | List to append
return | array | Concatenated list of $a and $b


---

## _cons

__Cons Operator__ :: a -> [a] -> [a]



Given a value and an array, append that value to the end of the array.

```
$cons(3, [1, 2]); [1, 2, 3]
$cons(1, []); [1]
```

Parameter | Type | Description
-|-|-
$a | mixed | Value to add to array
$arr | array | Array to add value to
return | array | Array with value added


---

## _contains

__Array Contains Element__ :: a -> [a] -> Bool



Returns true if a given array contains the item to test, or false if
it does not.

```
$contains(1, [1, 2, 3]); // true
$contains('a', ['b', 'c', 'd']); // false
```

Parameter | Type | Description
-|-|-
$item | mixed | Item to test for
$list | array | Array to test for the existence of $item in
return | bool | Whether or not $item is in $list


---

## _drop

__Drop Elements__ :: Int -> [a] -> [a]



Given some number n, drop n elements from an input array and return the rest of
the elements. If n is greater than the length of the array, returns an empty array.

```
$drop(2, [1, 2, 3, 4]); // [3, 4]
$drop(4, [1, 2]); // []
```

Parameter | Type | Description
-|-|-
$n | Int | The number of elements to drop
$list | array | List to drop elements from
return | array | Original list minus n elements from the front


---

## _dropWhile

__Drop Elements with Predicate__ :: (a -> Bool) -> [a] -> [a]



Given some function that returns true or false, drop elements from an array starting
at the front, testing each element along the way, until that function returns false.
Return the array without all of those elements.

```
$greaterThanOne = function($n) { return $n > 1; };

$dropWhile($greaterThanOne, [2, 4, 6, 1, 2, 3]); // [1, 2, 3]
```

Parameter | Type | Description
-|-|-
$predicate | callable | Function to use for testing
$list | array | List to drop from
return | array | List with elements removed from the front


---

## _filter

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
$f | Callable | Test function - should take an `a` and return a Bool
$arr | array | List to filter
return | array | Result of filtering the list


---

## _flatten

__Array Flatten__ :: [a] -> [b]



Flattens a nested array structure into a single-dimensional array. Can handle
arrays of arbitrary dimension.

```
$flatten([1, [2], [[[3, 4, [5]]]]]); // [1, 2, 3, 4, 5]
```

Parameter | Type | Description
-|-|-
$list | array | Nested array to flatten
return | array | Result of flattening $list into a 1-dimensional list


---

## _foldl

__List Fold - From Left__ :: (b -> a -> b) -> b -> [a] -> b



Fold a list by iterating over the list from left to right. Pass each element, one by one, into
the fold function $f, and carry its value over to the next iteration. Also referred to as array
reduce.

```
$add = function($a, $b) { return $a + $b; };
$and = Logic::using('logicalAnd'); // Boolean And (Bool -> Bool -> Bool)

$foldl($add, 0, [1, 2, 3]); // 6
$foldl($and, True, [True, True]); // True
$foldl($and, True, [True, True, False]); // False
```

Parameter | Type | Description
-|-|-
$f | callable | Function to use in each iteration if the fold
$seed | mixed | The initial value to use in the  fold function along with the first element
$list | array | The list to fold over
return | mixed | The result of applying the fold function to each element one by one


---

## _groupBy

__Group By__ :: (a -> String) -> [a] -> [[a]]



Given a function that turns an element into a string, map over a list of elements
and return a multi-dimensional array with elements grouped together by their key
generator.

```
$testCase = [1, 2, 3, 4, 5, 6, 7];
$keyGen = function($a) {
    return ($a % 2 == 0) ? 'even' : 'odd';
};

$groupBy($keyGen, $testCase); // ['even' => [2, 4, 6], 'odd' => [1, 3, 5, 7]]
```

Parameter | Type | Description
-|-|-
$keyGen | \Closure | Key generating function
$list | array | List to group
return | array | Multidimensional array of grouped elements


---

## _head

__List Head__ :: [a] -> a


!!! Warning
    Throws \Vector\Core\Exception\EmptyListException if argument is empty list


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
$list | array | Key/Value array or List
return | Mixed | First element of $list


---

## _index

__List Index__ :: Int -> [a] -> a


!!! Warning
    Throws \Vector\Core\Exception\IndexOutOfBoundsException if the requested index does not exist


Returns the element of a list at the given index. Throws an exception
if the given index does not exist in the list.

```
$index(0, [1, 2, 3]); // 1
$index('foo', ['bar' => 1, 'foo' => 2]); // 2
$index('baz', [1, 2, 3]); // Exception thrown
```

Parameter | Type | Description
-|-|-
$i | Int | Index to get
$list | array | List to get index from
return | Mixed | Item from $list and index $i


---

## _init

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
$list | array | Key/Value array or List
return | array | $list without the last element


---

## _keys

__Array Keys__ :: [a] -> [b]



Returns the keys of an associative key/value array. Returns numerical indexes
for non key/value arrays.

```
$keys(['a' => 1, 'b' => 2]); // ['a', 'b']
$keys([1, 2, 3]); // [0, 1, 2]
```

Parameter | Type | Description
-|-|-
$arr | array | List to get keys from
return | array | The keys of $arr


---

## _last

__Last List Value__ :: [a] -> a


!!! Warning
    Throws \Vector\Core\Exception\EmptyListException if argument is empty list


Returns the last element of an array, e.g. the complement of `init`. Works on key/value
arrays as well as 'regular' arrays. If an empty array is given, throws an exception.

```
$last([1, 2, 3]); // 3
$last(['a' => 1, 'b' => 2]); // 2
$last([]); // Exception thrown
```

Parameter | Type | Description
-|-|-
$list | array | Key/Value array or List
return | Mixed | The last element of $list


---

## _length

__Array Length__ :: [a] -> a



Returns the length of a list or array. Wraps php `count` function.

```
$length([1, 2, 3]); // 3
$length(['a' => 1, 'b' => 2]); // 2
```

Parameter | Type | Description
-|-|-
$list | array | Key/Value array or List
return | Int | Length of $list


---

## _map

__Array Map__ :: (a -> b) -> [a] -> [b]



Given some function and a list of arbitrary length, return a new array that is the
result of calling the given function on each element of the original list.

```
$map($add(1), [1, 2, 3]); // [2, 3, 4]
```

Parameter | Type | Description
-|-|-
$f | callable | Function to call for each element
$list | array | List to call function on
return | array | New list of elements after calling $f for the original list elements


---

## _maybeIndex

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
$i | Int | Index to get
$list | Mixed | List to get index from
return | \Maybe | Item from $list and index $i


---

## _replicate

__Replicate Item__ :: Int -> a -> [a]



Given some integer n and an item to repeat, repeat that item and place
the results into an array of length n.

```
$replicate(5, 'foo'); // ['foo', 'foo', 'foo', 'foo', 'foo']
```

Parameter | Type | Description
-|-|-
$n | int | Times to repeat some item
$item | mixed | Item to repeat
return | array | Array with $n items


---

## _reverse

__Array Reverse__ :: [a] -> [a]



Flip the order of a given array. Does not modify the original array.

```
$reverse([1, 2, 3]); // [3, 2, 1]
```

Parameter | Type | Description
-|-|-
$list | array | Array to flip
return | array | Array in the reverse order


---

## _set

__Set Array Value__ :: a -> [b] -> b -> [b]



Sets the value of an array at the given index; works for non-numerical indexes.
The value is set in an immutable way, so the original array is not modified.

```
$set(0, 'foo', [1, 2, 3]); // ['foo', 2, 3]
$set('c', 3, ['a' => 1, 'b' => 2]); // ['a' => 1, 'b' => 2, 'c' => 3]
```

Parameter | Type | Description
-|-|-
$key | Mixed | Element of index to modify
$arr | array | Array to modify
$val | Mixed | Value to set $arr[$key] to
return | array | Result of setting $arr[$key] = $val


---

## _tail

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
$list | array | Key/Value array or List
return | array | $list without the first element


---

## _take

__Take Elements__ :: Int -> [a] -> [a]



Given some number n, return the first n elements of a given array. Returns the whole
array if n is greater than the array length.

```
$take(3, [1, 2, 3, 4, 5]); // [1, 2, 3]
```

Parameter | Type | Description
-|-|-
$n | int | Number of elements to take
$list | array | Array to take elements from
return | array | First n elements of the array


---

## _takeWhile

__Take Elements with Predicate__ :: (a -> Bool) -> [a] -> [a]



Given some function that returns true or false, return the first elements of the array
that all pass the test, until the test fails.

```
$greaterThanOne = function($n) { return $n > 1; };

$takeWhile($greaterThanOne, [5, 5, 5, 1, 5, 5]); // [5, 5, 5]
```

Parameter | Type | Description
-|-|-
$predicate | callable | Function to use for testing each element
$list | array | List to take elements from
return | array | First elements of list that all pass the $predicate


---

## _values

__Array Values__ :: [a] -> [a]



Returns the values of an associative key/value array.

```
$values(['a' => 1, 'b' => 2]); // [1, 2]
$values([1, 2, 3]); // [1, 2, 3]
```

Parameter | Type | Description
-|-|-
$arr | array | Key/Value array
return | array | Indexed array with values of $arr


---

## _zip

__Array Zip__ :: [a] -> [b] -> [(a, b)]



Given two arrays a and b, return a new array where each element is a tuple of a and b. If a and b
are not the same length, the resultant array will always be the same length as the shorter array.

```
$zip([1, 2, 3], ['a', 'b', 'c']); // [[1, 'a'], [2, 'b'], [3, 'c']]
```

Parameter | Type | Description
-|-|-
$a | array | The first array to use when zipping
$b | array | The second array to use when zipping
return | array | Array of tuples from a and b combined


---

## _zipWith

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
$f | Callable | The function used to combine $a and $b
$a | array | The first array to use in the combinator
$b | array | The second array to use in the combinator
return | array | The result of calling f with each element of a and b in series


---
