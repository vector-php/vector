
## add

__Arithmetic Addition__ :: Num a => a -> a -> a



Add two numbers together

```
$add(2, 2); // 4
$add(-1, 2); // 1
```

Parameter | Type | Description
-|-|-
$a | \number | number $a First number to add
$b | \number | number $b Second number to add
return | \number | number    Addition of $a + $b


---

## divide

__Arithmetic Division__ :: Num a => a -> a -> a



Divide two numbers, with the first argument being the divisor

```
$divide(2, 8); // 4
$divide(4, 12); // 3
```

Parameter | Type | Description
-|-|-
$a | \number | number $a Denominator
$b | \number | number $b Numerator
return | float | float     Result of $b divided by $a


---

## max

__Maximum Value__ :: Num a => a -> a -> a



Returns the maximum of two arguments a and b. If a and b are equal, just returns the value.

```
$max(1, 2); // 2
$max(-1, -6); // -1
$max(5, 5); // 5
```

Parameter | Type | Description
-|-|-
$a | \number | number $a First number to compare
$b | \number | number $b Second number to compare
return | \number | number    The greater of the two numbers


---

## mean

__Arithmetic mean__ :: Num a => [a] -> a



Returns the average of a list, or zero for an empty list.

```
$mean([1, 2, 3]); // (1 + 2 + 3) / 3 = 2
$mean([]); // 0
```

Parameter | Type | Description
-|-|-
$arr | array | array  $arr List of numbers
return | \number | number      Mean of input list


---

## min

__Minimum Value__ :: Num a => a -> a -> a



Returns the minimum of two arguments a and b.
If a and be are equal, returns the first value. But since they're equal, that doesn't
really matter now does it?

```
$min(1, 2); // 1
$min(-1, -6); // -6
$min(5, 5); // 5
```

Parameter | Type | Description
-|-|-
$a | \number | number $a First number to compare
$b | \number | number $b Second number to compare
return | \number | number    The lesser of the two numbers


---

## mod

__Modulus Operator__ :: Int -> Int -> Int



Take the modulus of two integers, with the first argument being the divisor.
Returns the remainder of $b / $a.

```
$mod(2, 5); // 1
$mod(5, 12); // 2
$mod(3, 3); // 0
```

Parameter | Type | Description
-|-|-
$a | int | int $a Divisor
$b | int | int $b Numerator
return | int | int    Remainder of $b / $a


---

## multiply

__Arithmetic Multiplication__ :: Num a => a -> a -> a



Multiply two numbers together

```
$multiply(2, 4); // 8
$multiply(0, 4); // 0
```

Parameter | Type | Description
-|-|-
$a | \number | number $a First number to multiply
$b | \number | number $b Second number to multiply
return | \number | number    Multiplication of $a * $b


---

## negate

__Negate a number__ :: Num a => a -> a



Returns a given number * -1

```
$negate(4); // -4
$negate(0); // 0
```

Parameter | Type | Description
-|-|-
$a | \number | number $a Number to make negative
return | \number | number    The negated number


---

## pow

__Power function__ :: Num a => a -> a -> a



Arithmetic exponentiation. Raises the second argument to the power
of the first.

```
$pow(2, 3); // 3 ^ 2 = 9
$pow(3, 2); // 2 ^ 3 = 8
```

Parameter | Type | Description
-|-|-
$a | \number | number $a The power exponent
$b | \number | number $b The power base
return | \number | number    The base raised to the exponent's power


---

## product

__Array Product__ :: Num a => [a] -> a



Returns the product of a list of numbers, i.e. the result of multiplying
every element of a list together. Returns 1 for an empty list.

```
$product([2, 2, 3]); // 12
$product([]); // 1
```

Parameter | Type | Description
-|-|-
$a | array | array $a List of values to multiply
return | mixed | mixed    Product of every value in the list


---

## range

__Number Range__ :: Num a => a -> a -> a



Given two values m and n, return all values between m and n in an array, inclusive, with a
step size of $step. The list of numbers will start at the first value and approach the second value.

```
$range(1, 1, 5); // [1, 2, 3, 4, 5]
$range(2, 0, -3); // [0, -2]
$range(0, 0); // [0]
$range(0.1, 0, 0.5); // [0, 0.1, 0.2, 0.3, 0.4, 0.5]
```

Parameter | Type | Description
-|-|-
$step | \number | number $step The step sizes to take when building the range
$m | \number | number $m    First value in the list
$n | \number | number $n    Last value in the list
return | array | array        All the numbers between the first and last argument


---

## subtract

__Arithmetic Subtraction__ :: Num a => a -> a -> a



Subtracts two numbers, with the first argument being subtracted from the second.

```
$subtract(4, 9); // 5
$subtract(-1, 3); // 4
```

Parameter | Type | Description
-|-|-
$a | \number | number $a Number to subtract
$b | \number | number $b Number to subtract from
return | \number | number    Subtraction of $b - $a


---

## sum

__Array Sum__ :: Num a => [a] -> a



Add all the numbers of a list together and return their sum. If the given
list is empty, returns 0.

```
$sum([1, 2, 3]); // 6
$sum([]); // 0
```

Parameter | Type | Description
-|-|-
$a | array | array  $a List of numbers to add
return | \number | number    Sum of all the elements of the list


---
