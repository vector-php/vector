<?php

namespace Vector\Lib;

use Vector\Core\Exception\EmptyListException;
use Vector\Core\Exception\IndexOutOfBoundsException;

use Vector\Core\Module;
use Vector\Data\Maybe;

class ArrayList extends Module
{
    /**
     * List Head
     *
     * Returns the first element of a list, the element at index 0. Also functions
     * properly for key/value arrays, e.g. arrays whose first element may not necessarily
     * be index 0. If an empty array is given, head throws an Exception.
     *
     * ```
     * $head([1, 2, 3]); // 1
     * $head(['a' => 1, 'b' => 2]); // 1
     * $head([]); // Exception thrown
     * ```
     *
     * @type [a] -> a
     *
     * @throws \Vector\Core\Exception\EmptyListException if argument is empty list
     *
     * @param  array $list Key/Value array or List
     * @return Mixed       First element of $list
     */
    protected static function head($list)
    {
        if (count($list) === 0)
            throw new EmptyListException("'head' function is undefined for empty lists.");

        return array_slice($list, 0, 1)[0];
    }

    /**
     * List Tail
     *
     * Returns an array without its first element, e.g. the complement of `head`. Works on
     * key/value arrays as well as 'regular' arrays. If an empty array of an array of one element
     * is given, returns an empty array.
     *
     * ```
     * $tail([1, 2, 3]); // [2, 3]
     * $tail(['a' => 1, 'b' => 2]); // ['b' => 2];
     * ```
     *
     * @type [a] -> [a]
     *
     * @param  array $list Key/Value array or List
     * @return array       $list without the first element
     */
    protected static function tail($list)
    {
        return array_slice($list, 1, count($list));
    }

    /**
     * Initial List Values
     *
     * Returns an array without its last element, e.g. the inverse of `tail`. Works on
     * key/value arrays as well as 'regular' arrays. If an empty or single-value array is given,
     * returns an empty array.
     *
     * ```
     * $init([1, 2, 3]); // [1, 2]
     * $init(['a' => 1, 'b' => 2]); // ['a' => 1];
     * ```
     *
     * @type [a] -> [a]
     *
     * @param  array $list Key/Value array or List
     * @return array       $list without the last element
     */
    protected static function init($list)
    {
        return array_slice($list, 0, count($list) - 1);
    }

    /**
     * Last List Value
     *
     * Returns the last element of an array, e.g. the complement of `init`. Works on key/value
     * arrays as well as 'regular' arrays. If an empty array is given, throws an exception.
     *
     * ```
     * $last([1, 2, 3]); // 3
     * $last(['a' => 1, 'b' => 2]); // 2
     * $last([]); // Exception thrown
     * ```
     *
     * @type [a] -> a
     *
     * @throws \Vector\Core\Exception\EmptyListException if argument is empty list
     *
     * @param  array $list Key/Value array or List
     * @return Mixed       The last element of $list
     */
    protected static function last($list)
    {
        if (count($list) === 0)
            throw new EmptyListException("'last' function is undefined for empty lists.");

        return array_slice($list, -1, 1)[0];
    }

    /**
     * Array Length
     *
     * Returns the length of a list or array. Wraps php `count` function.
     *
     * ```
     * $length([1, 2, 3]); // 3
     * $length(['a' => 1, 'b' => 2]); // 2
     * ```
     *
     * @type [a] -> a
     *
     * @param  array $list Key/Value array or List
     * @return Int         Length of $list
     */
    protected static function length($list)
    {
        return count($list);
    }

    /**
     * List Index
     *
     * Returns the element of a list at the given index. Throws an exception
     * if the given index does not exist in the list.
     *
     * ```
     * $index(0, [1, 2, 3]); // 1
     * $index('foo', ['bar' => 1, 'foo' => 2]); // 2
     * $index('baz', [1, 2, 3]); // Exception thrown
     * ```
     *
     * @type Int -> [a] -> a
     *
     * @throws \Vector\Core\Exception\IndexOutOfBoundsException if the requested index does not exist
     *
     * @param  Int   $i    Index to get
     * @param  array $list List to get index from
     * @return Mixed       Item from $list and index $i
     */
    protected static function index($i, $list)
    {
        if (!array_key_exists($i, $list))
            throw new IndexOutOfBoundsException("'index' function tried to access non-existent index '$i'");

        return $list[$i];
    }

    /**
     * Maybe List Index
     *
     * Returns the element of a list at the given index, or nothing. Is safe to call
     * if you don't know if an index exists. If the index does not exist, returns `Nothing`.
     * Otherwise returns `Just a`.
     *
     * ```
     * $index(0, [1, 2, 3]); // Just 1
     * $index('foo', ['bar' => 1, 'foo' => 2]); // Just 2
     * $index('baz', [1, 2, 3]); // Nothing - (No exception thrown)
     * ```
     *
     * @type Int -> a -> Maybe a
     *
     * @param  Int   $i    Index to get
     * @param  Mixed $list List to get index from
     * @return Maybe       Item from $list and index $i
     */
    protected static function maybeIndex($i, $list)
    {
        if (array_key_exists($i, $list))
            return Maybe::Just($list[$i]);

        return Maybe::Nothing();
    }

    /**
     * Filter a List
     *
     * Returns a filtered list. Given a function that takes an element and returns
     * either true or false, return a list of all the elements
     * of the input list that pass the test.
     *
     * !!! Note
     *     'filter' preserves the keys of a key/value array - it only looks at values
     *
     * ```
     * $filter(function($a) { return $a > 2; }, [1, 2, 3, 4, 5]); // [3, 4, 5], using an inline function
     * $filter(function($a) { return $a > 2; }, ['foo' => 1, 'bar' => 3]); // ['foo' => 1]
     * $filter($lte(2), [1, 2, 3, 4, 5]); // [1, 2], using $lte from the Math module
     * ```
     *
     * @type (a -> Bool) -> [a] -> [a]
     *
     * @param  Callable $f   Test function - should take an `a` and return a Bool
     * @param  array    $arr List to filter
     * @return array         Result of filtering the list
     */
    protected static function filter($f, $arr)
    {
        return array_filter($arr, $f);
    }

    /**
     * Array Keys
     *
     * Returns the keys of an associative key/value array. Returns numerical indexes
     * for non key/value arrays.
     *
     * ```
     * $keys(['a' => 1, 'b' => 2]); // ['a', 'b']
     * $keys([1, 2, 3]); // [0, 1, 2]
     * ```
     *
     * @type [a] -> [b]
     *
     * @param  array $arr List to get keys from
     * @return array      The keys of $arr
     */
    protected static function keys($arr)
    {
        return array_keys($arr);
    }

    /**
     * Array Values
     *
     * Returns the values of an associative key/value array.
     *
     * ```
     * $values(['a' => 1, 'b' => 2]); // [1, 2]
     * $values([1, 2, 3]); // [1, 2, 3]
     * ```
     *
     * @type [a] -> [a]
     *
     * @param  array $arr Key/Value array
     * @return array      Indexed array with values of $arr
     */
    protected static function values($arr)
    {
        return array_values($arr);
    }

    /**
     * Array Concatenation
     *
     * Joins two arrays together, with the second argument being appended
     * to the end of the first. Defers to php build-in function `array_merge`,
     * so repeated keys will be overwritten.
     *
     * ```
     * $concat([1, 2], [2, 3]); // [1, 2, 2, 3]
     * $concat(['a' => 1, 'b' => 2], ['a' => 'foo', 'c' => 3]); // ['a' => 'foo', 'b' => 2, 'c' => 3]
     * ```
     *
     * @type [a] -> [a] -> [a]
     *
     * @param  array $a List to be appended to
     * @param  array $b List to append
     * @return array    Concatenated list of $a and $b
     */
    protected static function concat($a, $b)
    {
        return array_merge($a, $b);
    }

    /**
     * Set Array Value
     *
     * Sets the value of an array at the given index; works for non-numerical indexes.
     * The value is set in an immutable way, so the original array is not modified.
     *
     * ```
     * $set(0, 'foo', [1, 2, 3]); // ['foo', 2, 3]
     * $set('c', 3, ['a' => 1, 'b' => 2]); // ['a' => 1, 'b' => 2, 'c' => 3]
     * ```
     *
     * @type a -> [b] -> b -> [b]
     *
     * @param  Mixed $key Element of index to modify
     * @param  array $arr Array to modify
     * @param  Mixed $val Value to set $arr[$key] to
     * @return array      Result of setting $arr[$key] = $val
     */
    protected static function set($key, $arr, $val)
    {
        $arr[$key] = $val;
        return $arr;
    }

    /**
     * List Fold - From Left
     *
     * Fold a list by iterating over the list from left to right. Pass each element, one by one, into
     * the fold function $f, and carry its value over to the next iteration. Also referred to as array
     * reduce.
     *
     * ```
     * $add = function($a, $b) { return $a + $b; };
     * $and = Logic::using('logicalAnd'); // Boolean And (Bool -> Bool -> Bool)
     *
     * $foldl($add, 0, [1, 2, 3]); // 6
     * $foldl($and, True, [True, True]); // True
     * $foldl($and, True, [True, True, False]); // False
     * ```
     *
     * @type (a -> b -> b) -> b -> [a] -> b
     *
     * @param  callable $f    Function to use in each iteration if the fold
     * @param  mixed    $seed The initial value to use in the  fold function along with the first element
     * @param  array    $list The list to fold over
     * @return mixed          The result of applying the fold function to each element one by one
     */
    protected static function foldl($f, $seed, $list)
    {
        return array_reduce($list, $f, $seed);
    }

    /**
     * Custom Array Zip
     *
     * Given two arrays a and b, and some combinator f, combine the arrays using the combinator
     * f(ai, bi) into a new array c. If a and b are not the same length, the resultant array will
     * always be the same length as the shorter array, i.e. the zip stops when it runs out of pairs.
     *
     * ```
     * $combinator = function($a, $b) { return $a + $b; };
     * $zipWith($combinator, [1, 2, 3], [0, 8, -1]); // [1, 10, 2]
     * $zipWith($combinator, [0], [1, 2, 3]); // [1]
     * ```
     *
     * @type (a -> b -> c) -> [a] -> [b] -> [c]
     *
     * @param  Callable $f The function used to combine $a and $b
     * @param  array    $a The first array to use in the combinator
     * @param  array    $b The second array to use in the combinator
     * @return array       The result of calling f with each element of a and b in series
     */
    protected static function zipWith($f, $a, $b)
    {
        $result = [];

        while (($ai = array_shift($a)) !== null && ($bi = array_shift($b)) !== null) {
            $result[] = $f($ai, $bi);
        }

        return $result;
    }

    /**
     * Drop Elements
     *
     * Given some number n, drop n elements from an input array and return the rest of
     * the elements. If n is greater than the length of the array, returns an empty array.
     *
     * ```
     * $drop(2, [1, 2, 3, 4]); // [3, 4]
     * $drop(4, [1, 2]); // []
     * ```
     *
     * @type Int -> [a] -> [a]
     *
     * @param  Int   $n    The number of elements to drop
     * @param  array $list List to drop elements from
     * @return array       Original list minus n elements from the front
     */
    protected static function drop($n, $list)
    {
        return array_slice($list, $n, count($list));
    }
}
