## bifurcate

__Array Bifurcation__ :: (a -> Bool) -> [a] -> ([a], [a])

Given an array and some filtering test that returns a boolean, return two arrays - one array
of elements that pass the test, and another array of elements that don't. Similar to filter,
but returns the elements that fail as well.

```
ArrayList::bifurcate($isEven, [1, 2, 3, 4, 5]); // [[2, 4], [1, 3, 5]]
```

---

## concat

__Array Concatenation__ :: [a] -> [a] -> [a]

Joins two arrays together, with the second argument being appended
to the end of the first. Defers to php build-in function `array_merge`,
so repeated keys will be overwritten.

```
ArrayList::concat([1, 2], [2, 3]); // [1, 2, 2, 3]
ArrayList::concat(['a' => 1, 'b' => 2], ['a' => 'foo', 'c' => 3]); // ['a' => 'foo', 'b' => 2, 'c' => 3]
```

---

## cons

__Cons Operator__ :: a -> [a] -> [a]

Given a value and an array, append that value to the end of the array.

```
ArrayList::cons(3, [1, 2]); // [1, 2, 3]
ArrayList::cons(1, []); // [1]
```

---

## contains

__Array Contains Element__ :: a -> [a] -> Bool

Returns true if a given array contains the item to test, or false if
it does not.

```
ArrayList::contains(1, [1, 2, 3]); // true
ArrayList::contains('a', ['b', 'c', 'd']); // false
```

---

## drop

__Drop Elements__ :: Int -> [a] -> [a]

Given some number n, drop n elements from an input array and return the rest of
the elements. If n is greater than the length of the array, returns an empty array.

```
ArrayList::drop(2, [1, 2, 3, 4]); // [3, 4]
ArrayList::drop(4, [1, 2]); // []
```

---

## dropWhile

__Drop Elements with Predicate__ :: (a -> Bool) -> [a] -> [a]

Given some function that returns true or false, drop elements from an array starting
at the front, testing each element along the way, until that function returns false.
Return the array without all of those elements.

```
$greaterThanOne = function($n) { return $n > 1; };
ArrayList::dropWhile($greaterThanOne, [2, 4, 6, 1, 2, 3]); // [1, 2, 3]
```

---

## filter

__Filter a List__ :: (a -> Bool) -> [a] -> [a]

Returns a filtered list. Given a function that takes an element and returns
either true or false, return a list of all the elements
of the input list that pass the test.

```
ArrayList::filter(function($a) { return $a > 2; }, [1, 2, 3, 4, 5]); // [3, 4, 5], using an inline function
ArrayList::filter(function($a) { return $a > 2; }, ['foo' => 1, 'bar' => 3]); // ['foo' => 1]
ArrayList::filter(Math::lte(2), [1, 2, 3, 4, 5]); // [1, 2], using `lte` from the Math module
```

---

## flatten

__Array Flatten__ :: [a] -> [b]

Flattens a nested array structure into a single-dimensional array. Can handle
arrays of arbitrary dimension.

```
ArrayList::flatten([1, [2], [[[3, 4, [5]]]]]); // [1, 2, 3, 4, 5]
```

---

## foldl

__List Fold - From Left__ :: (b -> a -> b) -> b -> [a] -> b

Fold a list by iterating over the list from left to right. Pass each element, one by one, into
the fold function $f, and carry its value over to the next iteration. Also referred to as array
reduce.

```
$add = function($a, $b) { return $a + $b; };
ArrayList::foldl(Math::add(), 0, [1, 2, 3]); // 6
ArrayList::foldl(Logic::and(), True, [True, True]); // True
ArrayList::foldl(Logic::and(), True, [True, True, False]); // False
```

---

## groupBy

__Group By__ :: (a -> String) -> [a] -> [[a]]

Given a function that turns an element into a string, map over a list of elements
and return a multi-dimensional array with elements grouped together by their key
generator.

```
$testCase = [1, 2, 3, 4, 5, 6, 7];
$keyGen = function($a) {
    return ($a <= 3) ? 'small' : 'big';
};
ArrayList::groupBy($keyGen, $testCase); // ['small' => [1, 2, 3], 'big' => [4, 5, 6, 7]]
```

---

## head

__List Head__ :: [a] -> a

Returns the first element of a list, the element at index 0. Also functions
properly for key/value arrays, e.g. arrays whose first element may not necessarily
be index 0. If an empty array is given, head throws an Exception.

```
ArrayList::head([1, 2, 3]); // 1
ArrayList::head(['a' => 1, 'b' => 2]); // 1
ArrayList::head([]); // Exception thrown
```

---

## index

__List Index__ :: Int -> [a] -> a

Returns the element of a list at the given index. Throws an exception
if the given index does not exist in the list.

```
ArrayList::index(0, [1, 2, 3]); // 1
ArrayList::index('foo', ['bar' => 1, 'foo' => 2]); // 2
ArrayList::index('baz', [1, 2, 3]); // Exception thrown
```

---

## init

__Initial List Values__ :: [a] -> [a]

Returns an array without its last element, e.g. the inverse of `tail`. Works on
key/value arrays as well as 'regular' arrays. If an empty or single-value array is given,
returns an empty array.

```
ArrayList::init([1, 2, 3]); // [1, 2]
ArrayList::init(['a' => 1, 'b' => 2]); // ['a' => 1];
```

---

## keys

__Array Keys__ :: [a] -> [b]

Returns the keys of an associative key/value array. Returns numerical indexes
for non key/value arrays.

```
ArrayList::keys(['a' => 1, 'b' => 2]); // ['a', 'b']
ArrayList::keys([1, 2, 3]); // [0, 1, 2]
```

---

## last

__Last List Value__ :: [a] -> a

Returns the last element of an array, e.g. the complement of `init`. Works on key/value
arrays as well as 'regular' arrays. If an empty array is given, throws an exception.

```
ArrayList::last([1, 2, 3]); // 3
ArrayList::last(['a' => 1, 'b' => 2]); // 2
ArrayList::last([]); // Exception thrown
```

---

## length

__Array Length__ :: [a] -> a

Returns the length of a list or array. Wraps php `count` function.

```
ArrayList::length([1, 2, 3]); // 3
ArrayList::length(['a' => 1, 'b' => 2]); // 2
```

---

## map

__Array Map__ :: (a -> b) -> [a] -> [b]

Given some function and a list of arbitrary length, return a new array that is the
result of calling the given function on each element of the original list.

```
ArrayList::map($add(1), [1, 2, 3]); // [2, 3, 4]
```

---

## mapIndexed

__Array Map Indexed__ :: (a -> b -> c) -> [a] -> [c]

Given some function and a list of arbitrary length, return a new array that is the
result of calling the given function on each element of the original list. The first argument
of the mapping function is the value, and the second argument is the key or index of the array being
mapped over.

```
ArrayList::mapIndexed($filterEvenIndexes, [1, 2, 3]); // [null, 2, null]
```

---

## replicate

__Replicate Item__ :: Int -> a -> [a]

Given some integer n and an item to repeat, repeat that item and place
the results into an array of length n.

```
ArrayList::replicate(5, 'foo'); // ['foo', 'foo', 'foo', 'foo', 'foo']
```

---

## reverse

__Array Reverse__ :: [a] -> [a]

Flip the order of a given array. Does not modify the original array.

```
ArrayList::reverse([1, 2, 3]); // [3, 2, 1]
```

---

## setIndex

__Set Array Value__ :: a -> b -> [b] -> [b]

Sets the value of an array at the given index; works for non-numerical indexes.
The value is set in an immutable way, so the original array is not modified.

```
ArrayList::setValue(0, 'foo', [1, 2, 3]); // ['foo', 2, 3]
ArrayList::setValue('c', 3, ['a' => 1, 'b' => 2]); // ['a' => 1, 'b' => 2, 'c' => 3]
```

---

## sort

__Array Sort__ :: (a -> a -> Int) -> [a] -> [a]

Given a function that compares two values, sort an array. This function defers to usort
but does not mutate the original array. The comparison function should return -1 if the
first argument is ordered before the second, 0 if it's the same ordering, and 1 if
first argument is ordered after the second.

```
$comp = function($a, $b) { return $a <=> $b; };
ArrayList::sort($comp, [3, 2, 1]);
```

---

## tail

__List Tail__ :: [a] -> [a]

Returns an array without its first element, e.g. the complement of `head`. Works on
key/value arrays as well as 'regular' arrays. If an empty array of an array of one element
is given, returns an empty array.

```
ArrayList::([1, 2, 3]); // [2, 3]
ArrayList::(['a' => 1, 'b' => 2]); // ['b' => 2];
```

---

## take

__Take Elements__ :: Int -> [a] -> [a]

Given some number n, return the first n elements of a given array. Returns the whole
array if n is greater than the array length.

```
ArrayList::take(3, [1, 2, 3, 4, 5]); // [1, 2, 3]
```

---

## takeWhile

__Take Elements with Predicate__ :: (a -> Bool) -> [a] -> [a]

Given some function that returns true or false, return the first elements of the array
that all pass the test, until the test fails.

```
$greaterThanOne = function($n) { return $n > 1; };
ArrayList::takeWhile($greaterThanOne, [5, 5, 5, 1, 5, 5]); // [5, 5, 5]
```

---

## unique

__Unique__ :: [a] -> [a]

Given a list, return only unique values

```
ArrayList::unique([1, 2, 2, 4]); // [1, 2, 4]
```

---

## values

__Array Values__ :: [a] -> [a]

Returns the values of an associative key/value array.

```
ArrayList::values(['a' => 1, 'b' => 2]); // [1, 2]
ArrayList::values([1, 2, 3]); // [1, 2, 3]
```

---

## zip

__Array Zip__ :: [a] -> [b] -> [(a, b)]

Given two arrays a and b, return a new array where each element is a tuple of a and b. If a and b
are not the same length, the resultant array will always be the same length as the shorter array.

```
ArrayList::zip([1, 2, 3], ['a', 'b', 'c']); // [[1, 'a'], [2, 'b'], [3, 'c']]
```

---

## zipWith

__Custom Array Zip__ :: (a -> b -> c) -> [a] -> [b] -> [c]

Given two arrays a and b, and some combinator f, combine the arrays using the combinator
f(ai, bi) into a new array c. If a and b are not the same length, the resultant array will
always be the same length as the shorter array, i.e. the zip stops when it runs out of pairs.

```
$combinator = function($a, $b) { return $a + $b; };
ArrayList::zipWith($combinator, [1, 2, 3], [0, 8, -1]); // [1, 10, 2]
$combinator = function($a, $b) { return $a - $b; };
ArrayList::zipWith($combinator, [0], [1, 2, 3]); // [-1]
```

---

