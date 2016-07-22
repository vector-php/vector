## pipe

This function is currently missing documentation.

---

## compose

This function is currently missing documentation.

---

## flip

__Flip Combinator__ :: (a -> b -> c) -> b -> a -> c

Given a function that takes two arguments, return a new function that
takes those two arguments with their order reversed.

```
Math::subtract(2, 6); // 4
Lambda::flip(Math::subtract())(2, 6); // -4
```

---

## k

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

## id

__Identity Function__ :: a -> a

Given some value a, return a unchanged

```
Lambda::id(4); // 4
Lambda::id('foo'); // 'foo'
```

---

