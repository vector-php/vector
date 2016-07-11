
## _concat

__String Concatenation__ :: String -> String -> String



Concatenates the first argument to the second argument, provided both arguments
are strings. Defers to the PHP built-in concatenation.

```
$concat('as', 'df'); // 'dfas'
$concat('World', $concat('ello', 'H')); // 'HelloWorld'
```

Parameter | Type | Description
-|-|-
$addition | String | Thing to append
$original | String | Thing to append to
return | String | Concatenated strings


---

## _join

__String Joining__ :: String -> [String] -> String



Joins an array of strings together with a given delimiter. Works similarly
to PHP `implode`. The inverse of `split`.

```
$join(' ', ['Hello', 'World']); // 'Hello World'
$join('', ['a', 's', 'd', 'f']); // 'asdf'
```

Parameter | Type | Description
-|-|-
$on | String | Delimiter to join on
$string | array | List of strings to join together
return | String | Joined string based on delimiter


---

## _split

__String Splitting__ :: String -> String -> [String]



Split a string into parts based on a delimiter. Operates similar to php `explode`,
but is more consistent. Can split on empty delimiters, and trims out empty strings
after exploding.

```
$split('-', 'Hello-World'); // ['Hello', 'World']
$split('', 'asdf'); // ['a', 's', 'd', 'f']
$split('-', 'foo-bar-'); ['foo', 'bar']
```

Parameter | Type | Description
-|-|-
$on | String | Split delimiter
$string | String | Thing to split into pieces
return | array | List of chunks from splitting the string


---

## _startsWith

__Substring Match__ :: String -> String -> Bool



Determines if a string starts with a specific substring. Returns true if the string
matches the substring at its start, otherwise false.

```
$startsWith('as', 'asdf'); true
$startsWith('foo', 'barfoo'); false
```

Parameter | Type | Description
-|-|-
$subStr | String | Substring to test
$str | String | String to run test on
return | Bool | Whether or not the string starts with the substring


---

## _toLowercase

__Lowercase Conversion__ :: String -> String



Converts a string to lowercase.

```
$toLowercase('ASdf'); // 'asdf'
```

Parameter | Type | Description
-|-|-
$str | String | Original string
return | String | Lowercase string


---

## _toUppercase

__Uppercase Conversion__ :: String -> String



Converts a string to uppercase.

```
$toUppercase('asdf'); // 'ASDF'
```

Parameter | Type | Description
-|-|-
$str | String | Original string
return | String | Uppercase string


---

## _trim

__Trim Whitespace__ :: String -> String



Removes all leading and trailing whitespace from a string. Defers to
PHP trim.

```
$trim(' asdf '); // 'asdf'
```

Parameter | Type | Description
-|-|-
$str | String | string to trim
return | string | 


---
