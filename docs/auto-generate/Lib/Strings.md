
## concat

> String -> String -> String

__String Concatenation__



Concatenates the first argument to the second argument, provided both arguments
are strings. Defers to the PHP built-in concatenation.

```
$concat('as', 'df'); // 'dfas'
$concat('World', $concat('ello', 'H')); // 'HelloWorld'
```

---

## join

> String -> [String] -> String

__String Joining__



Joins an array of strings together with a given delimeter. Works similarly
to PHP `implode`. The inverse of `split`.

```
$join(' ', ['Hello', 'World']); // 'Hello World'
$join('', ['a', 's', 'd', 'f']); // 'asdf'
```

---

## split

> String -> String -> [String]

__String Splitting__



Split a string into parts based on a delimeter. Operates similar to php `explode`,
but is more consistent. Can split on empty delimters, and trims out empty strings
after exploding.

```
$split('-', 'Hello-World'); // ['Hello', 'World']
$split('', 'asdf'); // ['a', 's', 'd', 'f']
$split('-', 'foo-bar-'); ['foo', 'bar']
```

---

## startsWith

> String -> String -> Bool

__Substring Match__



Determines if a string starts with a specific substring. Returns true if the string
matches the substring at its start, otherwise false.

```
$startsWith('as', 'asdf'); true
$startsWith('foo', 'barfoo'); false
```

---

## toLowercase

> String -> String

__Lowercase Conversion__



Converts a string to lowercase.

```
$toLowercase('ASdf'); // 'asdf'
```

---
