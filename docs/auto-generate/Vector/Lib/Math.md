## add

[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Math.php#L42)

__Arithmetic Addition__ :: Number a => a -> a -> a

Add two numbers together.

```
Math::add(2, 2); // 4
Math::add(-1, 2); // 1
```

---

## divide

[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Math.php#L181)

__Arithmetic Division__ :: Number a => a -> a -> a

Divide two numbers, with the first argument being the divisor.

```
Math::divide(2, 8); // 4
Math::divide(4, 12); // 3
```

---

## max

[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Math.php#L291)

__Maximum Value__ :: Number a => a -> a -> a

Returns the maximum of two arguments a and b. If a and b are equal, just returns the value.

```
Math::max(1, 2); // 2
Math::max(-1, -6); // -1
Math::max(5, 5); // 5
```

---

## mean

[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Math.php#L335)

__Arithmetic mean__ :: Number a => [a] -> a

Returns the average of a list, or zero for an empty list.

```
Math::mean([1, 2, 3]); // (1 + 2 + 3) / 3 = 2
Math::mean([]); // 0
```

---

## min

[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Math.php#L266)

__Minimum Value__ :: Number a => a -> a -> a

Returns the minimum of two arguments a and b.
If a and be are equal, returns the first value. But since they're equal, that doesn't
really matter now does it?

```
Math::min(1, 2); // 1
Math::min(-1, -6); // -6
Math::min(5, 5); // 5
```

---

## mod

[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Math.php#L207)

__Modulus Operator__ :: Int -> Int -> Int

Take the modulus of two integers, with the first argument being the divisor.
Returns the remainder of $b / $a.

```
Math::mod(2, 5); // 1
Math::mod(5, 12); // 2
Math::mod(3, 3); // 0
```

---

## multiply

[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Math.php#L132)

__Arithmetic Multiplication__ :: Number a => a -> a -> a

Multiply two numbers together.

```
Math::multiply(2, 4); // 8
Math::multiply(0, 4); // 0
```

---

## negate

[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Math.php#L88)

__Negate a number.__ :: Number a => a -> a

Returns a given number * -1.

```
Math::negate(4); // -4
Math::negate(0); // 0
```

---

## pow

[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Math.php#L314)

__Power function__ :: Number a => a -> a -> a

Arithmetic exponentiation. Raises the second argument to the power
of the first.

```
Math::pow(2, 3); // 3 ^ 2 = 9
Math::pow(3, 2); // 2 ^ 3 = 8
```

---

## product

[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Math.php#L154)

__Array Product__ :: Number a => [a] -> a

Returns the product of a list of numbers, i.e. the result of multiplying
every element of a list together. Returns 1 for an empty list.

```
Math::product([2, 2, 3]); // 12
Math::product([]); // 1
```

---

## range

[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Math.php#L237)

__Number Range__ :: Number a => a -> a -> a

Given two values m and n, return all values between m and n in an array, inclusive, with a
step size of $step. The list of numbers will start at the first value and approach the second value.

```
Math::range(1, 1, 5); // [1, 2, 3, 4, 5]
Math::range(2, 0, -3); // [0, -2]
Math::range(0, 0, 0); // [0]
Math::range(0.1, 0, 0.5); // [0, 0.1, 0.2, 0.3, 0.4, 0.5]
```

---

## subtract

[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Math.php#L110)

__Arithmetic Subtraction.__ :: Number a => a -> a -> a

Subtracts two numbers, with the first argument being subtracted from the second.

```
Math::subtract(4, 9); // 5
Math::subtract(-1, 3); // 4
```

---

## sum

[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Math.php#L64)

__Array Sum__ :: Number a => [a] -> a

Add all the numbers of a list together and return their sum. If the given
list is empty, returns 0.

```
Math::sum([1, 2, 3]); // 6
Math::sum([]); // 0
```

---

