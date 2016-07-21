## concat

__String Concatenation__ :: String -> String -> String

Concatenates the first argument to the second argument, provided both arguments
are strings. Defers to the PHP built-in concatenation.

```
Strings::concat('as', 'df'); // 'dfas'
Strings::concat('World', $concat('ello', 'H')); // 'HelloWorld'
```

---

## split

__String Splitting__ :: String -> String -> [String]

Split a string into parts based on a delimiter. Operates similar to php `explode`,
but is more consistent. Can split on empty delimiters, and trims out empty strings
after exploding.

```
Strings::split('-', 'Hello-World'); // ['Hello', 'World']
Strings::split('', 'asdf'); // ['a', 's', 'd', 'f']
Strings::split('-', 'foo-bar-'); ['foo', 'bar']
```

---

## startsWith

__Substring Match__ :: String -> String -> Bool

Determines if a string starts with a specific substring. Returns true if the string
matches the substring at its start, otherwise false.

```
Strings::startsWith('as', 'asdf'); true
Strings::startsWith('foo', 'barfoo'); false
```

---

## toLowercase

__Lowercase Conversion__ :: String -> String

Converts a string to lowercase.

```
Strings::toLowercase('ASdf'); // 'asdf'
```

---

## toUppercase

__Uppercase Conversion__ :: String -> String

Converts a string to uppercase.

```
Strings::toUppercase('asdf'); // 'ASDF'
```

---

## trim

__Trim Whitespace__ :: String -> String

Removes all leading and trailing whitespace from a string. Defers to
PHP trim.

```
Strings::trim(' asdf '); // 'asdf'
```

---

## join

__String Joining__ :: String -> [String] -> String

Joins an array of strings together with a given delimiter. Works similarly
to PHP `implode`. The inverse of `split`.

```
Strings::join(' ', ['Hello', 'World']); // 'Hello World'
Strings::join('', ['a', 's', 'd', 'f']); // 'asdf'
```

---

