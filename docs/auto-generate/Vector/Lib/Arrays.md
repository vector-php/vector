## bifurcate[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Arrays.php#L576)

__Array Bifurcation__ :: (a -> Bool) -> [a] -> ([a], [a])

Given an array and some filtering test that returns a boolean, return two arrays - one array
of elements that pass the test, and another array of elements that don't. Similar to filter,
but returns the elements that fail as well.

```
Arrays::bifurcate($isEven, [1, 2, 3, 4, 5]); // [[2, 4], [1, 3, 5]]
```

---

## concat[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Arrays.php#L441)

__Array Concatenation__ :: [a] -> [a] -> [a]

Joins two arrays together, with the second argument being appended
to the end of the first. Defers to php build-in function `array_merge`,
so repeated keys will be overwritten.

```
Arrays::concat([1, 2], [2, 3]); // [1, 2, 2, 3]
Arrays::concat(['a' => 1, 'b' => 2], ['a' => 'foo', 'c' => 3]); // ['a' => 'foo', 'b' => 2, 'c' => 3]
```

---

## cons[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Arrays.php#L62)

__Cons Operator__ :: a -> [a] -> [a]

Given a value and an array, append that value to the end of the array.

```
Arrays::cons(3, [1, 2]); // [1, 2, 3]
Arrays::cons(1, []); // [1]
```

---

## contains[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Arrays.php#L758)

__Array Contains Element__ :: a -> [a] -> Bool

Returns true if a given array contains the item to test, or false if
it does not.

```
Arrays::contains(1, [1, 2, 3]); // true
Arrays::contains('a', ['b', 'c', 'd']); // false
```

---

## drop[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Arrays.php#L610)

__Drop Elements__ :: Int -> [a] -> [a]

Given some number n, drop n elements from an input array and return the rest of
the elements. If n is greater than the length of the array, returns an empty array.

```
Arrays::drop(2, [1, 2, 3, 4]); // [3, 4]
Arrays::drop(4, [1, 2]); // []
```

---

## dropWhile[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Arrays.php#L632)

__Drop Elements with Predicate__ :: (a -> Bool) -> [a] -> [a]

Given some function that returns true or false, drop elements from an array starting
at the front, testing each element along the way, until that function returns false.
Return the array without all of those elements.

```
$greaterThanOne = function($n) { return $n > 1; };
Arrays::dropWhile($greaterThanOne, [2, 4, 6, 1, 2, 3]); // [1, 2, 3]
```

---

## filter[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Arrays.php#L354)

__Filter a List__ :: (a -> Bool) -> [a] -> [a]

Returns a filtered list. Given a function that takes an element and returns
either true or false, return a list of all the elements
of the input list that pass the test.

```
Arrays::filter(function($a) { return $a > 2; }, [1, 2, 3, 4, 5]); // [3, 4, 5], using an inline function
Arrays::filter(function($a) { return $a > 2; }, ['foo' => 1, 'bar' => 3]); // ['foo' => 1]
Arrays::filter(Math::lte(2), [1, 2, 3, 4, 5]); // [1, 2], using `lte` from the Math module
```

---

## first[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Arrays.php#L368)

__First Element w/ Test__ :: No type given for this function.



TODO---

## flatten[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Arrays.php#L728)

__Array Flatten__ :: [a] -> [b]

Flattens a nested array structure into a single-dimensional array. Can handle
arrays of arbitrary dimension.

```
Arrays::flatten([1, [2], [[[3, 4, [5]]]]]); // [1, 2, 3, 4, 5]
```

---

## foldl[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Arrays.php#L495)

__List Fold - From Left__ :: (b -> a -> b) -> b -> [a] -> b

Fold a list by iterating over the list from left to right. Pass each element, one by one, into
the fold function $f, and carry its value over to the next iteration. Also referred to as array
reduce.

```
$add = function($a, $b) { return $a + $b; };
Arrays::foldl(Math::add(), 0, [1, 2, 3]); // 6
Arrays::foldl(Logic::and(), True, [True, True]); // True
Arrays::foldl(Logic::and(), True, [True, True, False]); // False
```

---

## groupBy[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Arrays.php#L88)

__Group By__ :: No type given for this function.

Given a function that turns an element into a string, map over a list of elements
and return a multi-dimensional array with elements grouped together by their key
generator.

```
$testCase = [1, 2, 3, 4, 5, 6, 7];
$keyGen = function($a) {
    return ($a <= 3) ? 'small' : 'big';
};
Arrays::groupBy($keyGen, $testCase); // ['small' => [1, 2, 3], 'big' => [4, 5, 6, 7]]
```

---

## head[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Arrays.php#L119)

__List Head__ :: [a] -> a

Returns the first element of a list, the element at index 0. Also functions
properly for key/value arrays, e.g. arrays whose first element may not necessarily
be index 0. If an empty array is given, head throws an Exception.

```
Arrays::head([1, 2, 3]); // 1
Arrays::head(['a' => 1, 'b' => 2]); // 1
Arrays::head([]); // Exception thrown
```

---

## index[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Arrays.php#L316)

__List Index__ :: Int -> [a] -> a

Returns the element of a list at the given index. Throws an exception
if the given index does not exist in the list.

```
Arrays::index(0, [1, 2, 3]); // 1
Arrays::index('foo', ['bar' => 1, 'foo' => 2]); // 2
Arrays::index('baz', [1, 2, 3]); // Exception thrown
```

---

## init[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Arrays.php#L236)

__Initial List Values__ :: [a] -> [a]

Returns an array without its last element, e.g. the inverse of `tail`. Works on
key/value arrays as well as 'regular' arrays. If an empty or single-value array is given,
returns an empty array.

```
Arrays::init([1, 2, 3]); // [1, 2]
Arrays::init(['a' => 1, 'b' => 2]); // ['a' => 1];
```

---

## keys[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Arrays.php#L396)

__Array Keys__ :: [a] -> [b]

Returns the keys of an associative key/value array. Returns numerical indexes
for non key/value arrays.

```
Arrays::keys(['a' => 1, 'b' => 2]); // ['a', 'b']
Arrays::keys([1, 2, 3]); // [0, 1, 2]
```

---

## last[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Arrays.php#L263)

__Last List Value__ :: [a] -> a

Returns the last element of an array, e.g. the complement of `init`. Works on key/value
arrays as well as 'regular' arrays. If an empty array is given, throws an exception.

```
Arrays::last([1, 2, 3]); // 3
Arrays::last(['a' => 1, 'b' => 2]); // 2
Arrays::last([]); // Exception thrown
```

---

## length[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Arrays.php#L288)

__Array Length__ :: [a] -> a

Returns the length of a list or array. Wraps php `count` function.

```
Arrays::length([1, 2, 3]); // 3
Arrays::length(['a' => 1, 'b' => 2]); // 2
```

---

## map[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Arrays.php#L143)

__Array Map__ :: (a -> b) -> [a] -> [b]

Given some function and a list of arbitrary length, return a new array that is the
result of calling the given function on each element of the original list.

```
Arrays::map($add(1), [1, 2, 3]); // [2, 3, 4]
```

---

## mapIndexed[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Arrays.php#L165)

__Array Map Indexed__ :: (a -> b -> c) -> [a] -> [c]

Given some function and a list of arbitrary length, return a new array that is the
result of calling the given function on each element of the original list. The first argument
of the mapping function is the value, and the second argument is the key or index of the array being
mapped over.

```
Arrays::mapIndexed($filterEvenIndexes, [1, 2, 3]); // [null, 2, null]
```

---

## replicate[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Arrays.php#L778)

__Replicate Item__ :: Int -> a -> [a]

Given some integer n and an item to repeat, repeat that item and place
the results into an array of length n.

```
Arrays::replicate(5, 'foo'); // ['foo', 'foo', 'foo', 'foo', 'foo']
```

---

## reverse[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Arrays.php#L709)

__Array Reverse__ :: [a] -> [a]

Flip the order of a given array. Does not modify the original array.

```
Arrays::reverse([1, 2, 3]); // [3, 2, 1]
```

---

## setIndex[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Arrays.php#L465)

__Set Array Value__ :: a -> b -> [b] -> [b]

Sets the value of an array at the given index; works for non-numerical indexes.
The value is set in an immutable way, so the original array is not modified.

```
Arrays::setValue(0, 'foo', [1, 2, 3]); // ['foo', 2, 3]
Arrays::setValue('c', 3, ['a' => 1, 'b' => 2]); // ['a' => 1, 'b' => 2, 'c' => 3]
```

---

## sort[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Arrays.php#L188)

__Array Sort__ :: (a -> a -> Int) -> [a] -> [a]

Given a function that compares two values, sort an array. This function defers to usort
but does not mutate the original array. The comparison function should return -1 if the
first argument is ordered before the second, 0 if it's the same ordering, and 1 if
first argument is ordered after the second.

```
$comp = function($a, $b) { return $a <=> $b; };
Arrays::sort($comp, [3, 2, 1]);
```

---

## tail[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Arrays.php#L213)

__List Tail__ :: [a] -> [a]

Returns an array without its first element, e.g. the complement of `head`. Works on
key/value arrays as well as 'regular' arrays. If an empty array of an array of one element
is given, returns an empty array.

```
Arrays::([1, 2, 3]); // [2, 3]
Arrays::(['a' => 1, 'b' => 2]); // ['b' => 2];
```

---

## take[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Arrays.php#L660)

__Take Elements__ :: Int -> [a] -> [a]

Given some number n, return the first n elements of a given array. Returns the whole
array if n is greater than the array length.

```
Arrays::take(3, [1, 2, 3, 4, 5]); // [1, 2, 3]
```

---

## takeLast[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Arrays.php#L821)

__takeLast__ :: Int -> [a] -> [a]

Return the last n items from a list

```
Arrays::takeLast(2, [1, 2, 2, 4]); // [2, 4]
```

---

## takeWhile[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Arrays.php#L681)

__Take Elements with Predicate__ :: (a -> Bool) -> [a] -> [a]

Given some function that returns true or false, return the first elements of the array
that all pass the test, until the test fails.

```
$greaterThanOne = function($n) { return $n > 1; };
Arrays::takeWhile($greaterThanOne, [5, 5, 5, 1, 5, 5]); // [5, 5, 5]
```

---

## unique[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Arrays.php#L802)

__Unique__ :: [a] -> [a]

Given a list, return only unique values

```
Arrays::unique([1, 2, 2, 4]); // [1, 2, 4]
```

---

## values[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Arrays.php#L417)

__Array Values__ :: [a] -> [a]

Returns the values of an associative key/value array.

```
Arrays::values(['a' => 1, 'b' => 2]); // [1, 2]
Arrays::values([1, 2, 3]); // [1, 2, 3]
```

---

## zip[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Arrays.php#L548)

__Array Zip__ :: [a] -> [b] -> [(a, b)]

Given two arrays a and b, return a new array where each element is a tuple of a and b. If a and b
are not the same length, the resultant array will always be the same length as the shorter array.

```
Arrays::zip([1, 2, 3], ['a', 'b', 'c']); // [[1, 'a'], [2, 'b'], [3, 'c']]
```

---

## zipWith[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Arrays.php#L522)

__Custom Array Zip__ :: (a -> b -> c) -> [a] -> [b] -> [c]

Given two arrays a and b, and some combinator f, combine the arrays using the combinator
f(ai, bi) into a new array c. If a and b are not the same length, the resultant array will
always be the same length as the shorter array, i.e. the zip stops when it runs out of pairs.

```
$combinator = function($a, $b) { return $a + $b; };
Arrays::zipWith($combinator, [1, 2, 3], [0, 8, -1]); // [1, 10, 2]
$combinator = function($a, $b) { return $a - $b; };
Arrays::zipWith($combinator, [0], [1, 2, 3]); // [-1]
```

---

