
## _add

__Arithmetic Addition__ :: Number a => a -> a -> a



Add two numbers together.

```
$add(2, 2); // 4
$add(-1, 2); // 1
```

Parameter | Type | Description
-|-|-
$a | \number | First number to add
$b | \number | Second number to add
return | \number | Addition of $a + $b


---

## _divide

__Arithmetic Division__ :: Number a => a -> a -> a



Divide two numbers, with the first argument being the divisor.

```
$divide(2, 8); // 4
$divide(4, 12); // 3
```

Parameter | Type | Description
-|-|-
$a | \number | Denominator
$b | \number | Numerator
return | float | Result of $b divided by $a


---

## _max

__Maximum Value__ :: Number a => a -> a -> a



Returns the maximum of two arguments a and b. If a and b are equal, just returns the value.

```
$max(1, 2); // 2
$max(-1, -6); // -1
$max(5, 5); // 5
```

Parameter | Type | Description
-|-|-
$a | \number | First number to compare
$b | \number | Second number to compare
return | \number | The greater of the two numbers


---

## _mean

__Arithmetic mean__ :: Number a => [a] -> a



Returns the average of a list, or zero for an empty list.

```
$mean([1, 2, 3]); // (1 + 2 + 3) / 3 = 2
$mean([]); // 0
```

Parameter | Type | Description
-|-|-
$arr | array | List of numbers
return | \number | Mean of input list


---

## _min

__Minimum Value__ :: Number a => a -> a -> a



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
$a | \number | First number to compare
$b | \number | Second number to compare
return | \number | The lesser of the two numbers


---

## _mod

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
$a | int | Divisor
$b | int | Numerator
return | int | Remainder of $b / $a


---

## _multiply

__Arithmetic Multiplication__ :: Number a => a -> a -> a



Multiply two numbers together.

```
$multiply(2, 4); // 8
$multiply(0, 4); // 0
```

Parameter | Type | Description
-|-|-
$a | \number | First number to multiply
$b | \number | Second number to multiply
return | \number | Multiplication of $a * $b


---

## _negate

__Negate a number.__ :: Number a => a -> a



Returns a given number * -1.

```
$negate(4); // -4
$negate(0); // 0
```

Parameter | Type | Description
-|-|-
$a | \number | Number to make negative
return | \number | The negated number


---

## _pow

__Power function__ :: Number a => a -> a -> a



Arithmetic exponentiation. Raises the second argument to the power
of the first.

```
$pow(2, 3); // 3 ^ 2 = 9
$pow(3, 2); // 2 ^ 3 = 8
```

Parameter | Type | Description
-|-|-
$a | \number | The power exponent
$b | \number | The power base
return | \number | The base raised to the exponent's power


---

## _product

__Array Product__ :: Number a => [a] -> a



Returns the product of a list of numbers, i.e. the result of multiplying
every element of a list together. Returns 1 for an empty list.

```
$product([2, 2, 3]); // 12
$product([]); // 1
```

Parameter | Type | Description
-|-|-
$a | array | List of values to multiply
return | mixed | Product of every value in the list


---

## _range

__Number Range__ :: Number a => a -> a -> a



Given two values m and n, return all values between m and n in an array, inclusive, with a
step size of $step. The list of numbers will start at the first value and approach the second value.

```
$range(1, 1, 5); // [1, 2, 3, 4, 5]
$range(2, 0, -3); // [0, -2]
$range(0, 0, 0); // [0]
$range(0.1, 0, 0.5); // [0, 0.1, 0.2, 0.3, 0.4, 0.5]
```

Parameter | Type | Description
-|-|-
$step | \number | The step sizes to take when building the range
$first | \number | First value in the list
$last | \number | Last value in the list
return | array | All the numbers between the first and last argument


---

## _subtract

__Arithmetic Subtraction.__ :: Number a => a -> a -> a



Subtracts two numbers, with the first argument being subtracted from the second.

```
$subtract(4, 9); // 5
$subtract(-1, 3); // 4
```

Parameter | Type | Description
-|-|-
$a | \number | Number to subtract
$b | \number | Number to subtract from
return | \number | Subtraction of $b - $a


---

## _sum

__Array Sum__ :: Number a => [a] -> a



Add all the numbers of a list together and return their sum. If the given
list is empty, returns 0.

```
$sum([1, 2, 3]); // 6
$sum([]); // 0
```

Parameter | Type | Description
-|-|-
$a | array | List of numbers to add
return | \number | Sum of all the elements of the list


---
