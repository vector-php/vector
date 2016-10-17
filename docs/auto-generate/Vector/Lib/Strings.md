## chomp

[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Strings.php#L230)

__Two-Sided Chomp__ :: String -> String

Removes the specified substring from both ends of the target string. Unlike PHP's
trim function, the substring to chomp is not a character mask -- rather it is a full
substring. This function is case sensitive.

```
Strings::chomp('a', 'abccba'); // 'bccb'
Strings::chomp('ab', 'abccba'); // 'abccba'
Strings::chomp('A', 'abccba'); // 'abccba'
```

---

## concat

[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Strings.php#L41)

__String Concatenation__ :: String -> String -> String

Concatenates the first argument to the second argument, provided both arguments
are strings. Defers to the PHP built-in concatenation.

```
Strings::concat('as', 'df'); // 'dfas'
Strings::concat('World', $concat('ello', 'H')); // 'HelloWorld'
```

---

## join

[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Strings.php#L255)

__String Joining__ :: String -> [String] -> String

Joins an array of strings together with a given delimiter. Works similarly
to PHP `implode`. The inverse of `split`.

```
Strings::join(' ', ['Hello', 'World']); // 'Hello World'
Strings::join('', ['a', 's', 'd', 'f']); // 'asdf'
```

---

## lchomp

[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Strings.php#L172)

__Left Chomp__ :: String -> String

Removes the specified substring from the left end of the target string. Unlike PHP's
trim function, the substring to chomp is not a character mask -- rather it is a full
substring. This function is case sensitive.

```
Strings::lchomp('He', 'Hello World'); // 'llo World'
Strings::lchomp('Hi', 'Hello World'); // 'Hello World'
Strings::lchomp('he', 'Hello World'); // 'Hello World'
```

---

## rchomp

[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Strings.php#L201)

__Right Chomp__ :: String -> String

Removes the specified substring from the right end of the target string. Unlike PHP's
trim function, the substring to chomp is not a character mask -- rather it is a full
substring. This function is case sensitive.

```
Strings::rchomp('ld', 'Hello World'); // 'Hello Wor'
Strings::rchomp('li', 'Hello World'); // 'Hello World'
Strings::rchomp('LD', 'Hello World'); // 'Hello World'
```

---

## replace

[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Strings.php#L274)

__String Replace__ :: String -> String -> String

Replace all occurrences of the search string with the replacement string.

```
Strings::replace('test', 'passes', 'this test']); // 'this passes'
```

---

## split

[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Strings.php#L68)

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

[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Strings.php#L94)

__Substring Match__ :: String -> String -> Bool

Determines if a string starts with a specific substring. Returns true if the string
matches the substring at its start, otherwise false.

```
Strings::startsWith('as', 'asdf'); true
Strings::startsWith('foo', 'barfoo'); false
```

---

## toLowercase

[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Strings.php#L112)

__Lowercase Conversion__ :: String -> String

Converts a string to lowercase.

```
Strings::toLowercase('ASdf'); // 'asdf'
```

---

## toUppercase

[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Strings.php#L130)

__Uppercase Conversion__ :: String -> String

Converts a string to uppercase.

```
Strings::toUppercase('asdf'); // 'ASDF'
```

---

## trim

[Source](https://github.com/joseph-walker/vector/blob/master/src/Vector/Lib/Strings.php#L149)

__Trim Whitespace__ :: String -> String

Removes all leading and trailing whitespace from a string. Defers to
PHP trim.

```
Strings::trim(' asdf '); // 'asdf'
```

---

