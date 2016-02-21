<?php

namespace Vector\Lib;

use Vector\Core\FunctionCapsule;
use Vector\Data\Maybe;

class ArrayList extends FunctionCapsule
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
     * @throws Vector\Core\Exception\EmptyListException;
     *
     * @param  [a] $list Key/Value array or List
     * @return a         First element of $list
     */
    protected static function head($list)
    {
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
     * @param  [a] $list Key/Value array or List
     * @return [a]       $list without the first element
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
     * @param  [a] $list Key/Value array or List
     * @return [a]       $list without the last element
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
     * @throws Vector\Core\Exception\EmptyListException;
     *
     * @param  [a] $list Key/Value array or List
     * @return a         The last element of $list
     */
    protected static function last($list)
    {
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
     * @param  [a] $list Key/Value array or List
     * @return Int       Length of $list
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
     * @param  Int $i    Index to get
     * @param  [a] $list List to get index from
     * @return a         Item from $list and index $i
     */
    protected static function index($i, $list)
    {
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
     * @param  Int      $i    Index to get
     * @param  [a]      $list List to get index from
     * @return Maybe(a)       Item from $list and index $i
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
     * ```
     * $filter(function($a) { return $a > 2; }, [1, 2, 3, 4, 5]); // [3, 4, 5], using an inline function
     * $filter($lte(2), [1, 2, 3, 4, 5]); // [1, 2], using $lte from the Math module
     * ```
     *
     * @type (a -> Bool) -> [a] -> [a]
     *
     * @param  (a -> Bool) $f   Test function - should take an `a` and return a Bool
     * @param  [a]         $arr List to filter
     * @return [a]              Result of filtering the list
     */
    protected static function filter($f, $arr)
    {
        return array_filter($arr, $f);
    }

    /**
     * Array Keys
     *
     * Returns the keys of an associative key/value array. Returns numerical indeces
     * for non key/value arrays.
     *
     * ```
     * $keys(['a' => 1, 'b' => 2]); // ['a', 'b']
     * $keys([1, 2, 3]); // [0, 1, 2]
     * ```
     *
     * @type [a] -> [b]
     *
     * @param  [a] $arr List to get keys from
     * @return [b]      The keys of $arr
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
     * @param  [a] $arr Key/Value array
     * @return [a]      Indexed array with values of $arr
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
     * @param  [a] $a List to be appended to
     * @param  [a] $b List to append
     * @return [a]    Concatenated list of $a and $b
     */
    protected static function concat($a, $b)
    {
        return array_merge($a, $b);
    }

    /**
     * Set Array Value
     *
     * Sets the value of an array at the given index; works for non-numerical indeces.
     * The value is set in an immutable way, so the original array is not modified.
     *
     * ```
     * $set(0, 'foo', [1, 2, 3]); // ['foo', 2, 3]
     * $set('c', 3, ['a' => 1, 'b' => 2]); // ['a' => 1, 'b' => 2, 'c' => 3]
     * ```
     *
     * @type a -> [b] -> b -> [b]
     *
     * @param  a   $key Element of index to modify
     * @param  [b] $arr Array to modify
     * @param  b   $val Value to set $arr[$key] to
     * @return [b]      Result of setting $arr[$key] = $val
     */
    protected static function set($key, $arr, $val)
    {
        $arr[$key] = $val;
        return $arr;
    }
}
