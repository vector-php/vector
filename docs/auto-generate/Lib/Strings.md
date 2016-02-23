
## concat

__String Concatenation__ :: String -> String -> String



Concatenates the first argument to the second argument, provided both arguments
are strings. Defers to the PHP built-in concatenation.

```
$concat('as', 'df'); // 'dfas'
$concat('World', $concat('ello', 'H')); // 'HelloWorld'
```

Parameter | Type | Description
-|-|-
$addition | String | String $addition Thing to append
$original | String | String $original Thing to append to
return | String | String           Concatenated strings


---

## join

__String Joining__ :: String -> [String] -> String



Joins an array of strings together with a given delimeter. Works similarly
to PHP `implode`. The inverse of `split`.

```
$join(' ', ['Hello', 'World']); // 'Hello World'
$join('', ['a', 's', 'd', 'f']); // 'asdf'
```

Parameter | Type | Description
-|-|-
$on | String | String $on     Delimeter to join on
$string | Array | Array  $string List of strings to join together
return | String | String         Joined string based on delimeter


---

## split

__String Splitting__ :: String -> String -> [String]



Split a string into parts based on a delimeter. Operates similar to php `explode`,
but is more consistent. Can split on empty delimters, and trims out empty strings
after exploding.

```
$split('-', 'Hello-World'); // ['Hello', 'World']
$split('', 'asdf'); // ['a', 's', 'd', 'f']
$split('-', 'foo-bar-'); ['foo', 'bar']
```

Parameter | Type | Description
-|-|-
$on | String | String $on     Split delimeter
$string | String | String $string Thing to split into pieces
return | Array | Array          List of chunks from splitting the string


---

## startsWith

__Substring Match__ :: String -> String -> Bool



Determines if a string starts with a specific substring. Returns true if the string
matches the substring at its start, otherwise false.

```
$startsWith('as', 'asdf'); true
$startsWith('foo', 'barfoo'); false
```

Parameter | Type | Description
-|-|-
$subStr | String | String $subStr Substring to test
$str | String | String $str    String to run test on
return | Bool | Bool           Whether or not the string starts with the substring


---

## toLowercase

__Lowercase Conversion__ :: String -> String



Converts a string to lowercase.

```
$toLowercase('ASdf'); // 'asdf'
```

Parameter | Type | Description
-|-|-
$str | String | String $str Original string
return | String | String      Lowercase string


---
