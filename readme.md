# Vector / Core

[![Build Status](https://travis-ci.org/joseph-walker/vector.svg?branch=master)](https://travis-ci.org/joseph-walker/vector)
[![Coverage Status](https://coveralls.io/repos/github/joseph-walker/vector/badge.svg?branch=master)](https://coveralls.io/github/joseph-walker/vector?branch=master)
[![Badge Status](https://img.shields.io/badge/badge%20status-dank-brightgreen.svg)](https://niceme.me/)

[Read the Docs](http://joseph-walker.github.io/vector/)

## Purpose
> Functional primitives for php

## Major Features
- Functors and Monads
- Autocurrying
- Composition
- Haskell-style module system

## PHP Version Support
- 5.6+

---

# Need To Add:

## ArrayList
- `adjust :: (a -> a) -> Int -> [a] -> [a]`<br>Applies a function to the value at a given index
- `all :: (a -> Bool) -> [a] -> Bool`<br>Returns true if every element of [a] passes the given test
- `any :: (a -> Bool) -> [a] -> Bool`<br>Returns true if any element of [a] passes the given test
- `append :: a -> [a] -> [a]`<br>Append a to [a]
- `concat :: [a] -> [a] -> [a]`<br>Concat two lists together
- `contains :: a -> [a] -> Bool`<br>Returns true if [a] contains a
- `drop :: Int -> [a] -> [a]`<br>Returns the given list sans the first n elements
- `dropLast :: Int -> [a] -> [a]`<br>Returns the given list sans the last n elements
- `dropWhile :: (a -> Bool) -> [a] -> [a]`<br>Returns the list sans the first elements that pass the given test
- `dropLastWhile :: (a -> Bool) -> [a] -> [a]`<br>Returns the list sans the last elements that pass the given test
- `filter :: (a -> Bool) -> [a] -> [a]`<br>Array filter
- `find :: (a -> Bool) -> [a] -> Maybe a`<br>Attempts to find an element by using a given test
- `findIndex :: (a -> Bool) -> [a] -> Maybe Int`Attempts to find an element's index by using a given test
- `findAll :: (a -> Bool) -> [a] -> [a]`<br>Attempts to find all the elements that pass the given test
- `indexOf :: a -> [a] -> Maybe Int`<br>Finds the index of the given element
- `flatten :: [a] -> [b]`<br>Flattens nested arrays
- `keys :: [a] -> [b]`<br>Returns array keys
- `values :: [a] -> [a]`<br>Returns array values
- `foldl :: (b -> a -> b) -> b -> [a] -> b`<br>Reduce left
- `foldr :: (a -> b -> b) -> b -> t a -> b`<br>Reduce right
- `repeat :: a -> Int -> [a]`<br>Repeat the given item n times
- `reverse :: [a] -> [a]`<br>Reverse a list
- `take :: Int -> [a] -> [a]`<br>Take n items from a list
- `takeLast :: Int -> [a] -> [a]`<br>Take n items from a list starting at the back
- `takeWhile :: (a -> Bool) -> [a] -> [a]`<br>Take items from a list while a given test passes
- `unique :: [a] -> [a]`<br>Return a list with duplicates removed
- `zip :: [a] -> [b] -> [[a, b]]`<br>Zip two lists together into a 2-d array
- `zipWith :: (a -> b -> c) -> [a] -> [b] -> [c]`<br>Zip two lists together with the given combinator function

## Logic
- `and :: Bool -> Bool -> Bool`<br>Logical and
- `or :: Bool -> Bool -> Bool`<br>Logical or
- `not :: Bool -> Bool`<br>Logical not

## String
- `toLower :: String -> String`<br>Returns a string in lowercase
- `toUpper :: String -> String`<br>Returns a string in uppercase
- `trim :: String -> String`<br>Returns a string with leading and trailing whitespace removed

## Monad
- `sequence :: Monad m => [m a] -> m [a]`<br>Convert a list of monads into a monad of lists

## Object
- `call :: String -> Object -> a`<br>Call the method String on the given Object and return its result

## Math
- `inc :: Int -> Int`<br>Increment
- `dec :: Int -> Int`<br>Decrement
- `mod :: Int -> Int -> Int`<br>Modulus operator, divisor is first argument
- `max :: Num -> Num -> Num`<br>Returns the maximum of its two arguments
- `min :: Num -> Num -> Num`<br>Returns the minimum of its two arguments
- `negate :: Num -> Num`<br>Returns the given number * -1
- `sum :: [Num] -> Num`<br>Returns the sum of the given list
- `product :: [Num] -> Num`<br>Returns the product of the given list
- `range :: Int -> Int -> [Int]`<br>Returns all integers between the given arguments, inclusive
