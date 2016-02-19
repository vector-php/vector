# Vector / Core

[![Build Status](https://travis-ci.org/joseph-walker/vector.svg?branch=master)](https://travis-ci.org/joseph-walker/vector)
[![Coverage Status](https://coveralls.io/repos/github/joseph-walker/vector/badge.svg?branch=master)](https://coveralls.io/github/joseph-walker/vector?branch=master)
[![Badge Status](https://img.shields.io/badge/badge%20status-dank-brightgreen.svg)](https://niceme.me/)

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
- adjust :: (a -> a) -> Int -> [a] -> [a]
- all :: (a -> Bool) -> [a] -> Bool
- any :: (a -> Bool) -> [a] -> Bool
- append :: a -> [a] -> [a]
- concat :: [a] -> [a] -> [a]
- contains :: a -> [a] -> Bool
- drop :: Int -> [a] -> [a]
- dropLast :: Int -> [a] -> [a]
- dropWhile :: (a -> Bool) -> [a] -> [a]
- dropLastWhile :: (a -> Bool) -> [a] -> [a]
- filter :: (a -> Bool) -> [a] -> [a]
- find :: (a -> Bool) -> [a] -> Maybe a
- findIndex :: (a -> Bool) -> [a] -> Maybe Int
- findAll :: (a -> Bool) -> [a] -> Maybe [a]
- indexOf :: a -> [a] -> Maybe Int
- flatten :: [a] -> [b]
- keys :: [a] -> [b]
- values :: [a] -> [a]
- foldl :: (b -> a -> b) -> b -> [a] -> b
- foldr :: (a -> b -> b) -> b -> t a -> b
- repeat :: a -> Int -> [a]
- reverse :: [a] -> [a]
- take :: Int -> [a] -> [a]
- takeLast :: Int -> [a] -> [a]
- takeWhile :: (a -> Bool) -> [a] -> [a]
- unique :: [a] -> [a]
- zip :: [a] -> [b] -> [[a, b]]
- zipWith :: (a -> b -> c) -> [a] -> [b] -> [c]

## Logic
- and :: Bool -> Bool -> Bool
- or :: Bool -> Bool -> Bool
- not :: Bool -> Bool

## String
- toLower :: String -> String
- toUpper :: String -> String
- trim :: String -> String

## Monad
- sequence :: Monad m => [m a] -> m [a]

## Object
- call :: String -> Object -> a

## Math
- inc :: Int -> Int
- dec :: Int -> Int
- mod :: Int -> Int -> Int
- max :: Num -> Num -> Num
- min :: Num -> Num -> Num
- negate :: Num -> Num
- sum :: [Num] -> Num
- product :: [Num] -> Num
- range :: Num -> Num -> [Num]
