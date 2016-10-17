## compose

This function is currently missing documentation.

---

## flip

[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Lambda.php#L46)

__Flip Combinator__ :: (a -> b -> c) -> b -> a -> c

Given a function that takes two arguments, return a new function that
takes those two arguments with their order reversed.

```
Math::subtract(2, 6); // 4
Lambda::flip(Math::subtract())(2, 6); // -4
```

---

## id

[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Lambda.php#L92)

__Identity Function__ :: a -> a

Given some value a, return a unchanged

```
Lambda::id(4); // 4
Lambda::id('foo'); // 'foo'
```

---

## k

[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Lambda.php#L70)

__K Combinator__ :: a -> (b -> a)

Given some value k, return a lambda expression which always evaluates to k, regardless
of any arguments it is given.

```
$alwaysFour = Lambda::k(4);
$alwaysFour('foo'); // 4
$alwaysFour(1, 2, 3); // 4
$alwaysFour(); // 4
```

---

## pipe

This function is currently missing documentation.

---

