<?php

namespace Vector\Lib;

use Vector\Core\Module;

class Strings extends Module
{
    /**
     * String Concatenation
     *
     * Concatenates the first argument to the second argument, provided both arguments
     * are strings. Defers to the PHP built-in concatenation.
     *
     * ```
     * $concat('as', 'df'); // 'dfas'
     * $concat('World', $concat('ello', 'H')); // 'HelloWorld'
     * ```
     *
     * @type String -> String -> String
     *
     * @param  String $addition Thing to append
     * @param  String $original Thing to append to
     * @return String           Concatenated strings
     */
    protected static function concat($addition, $original)
    {
        return $original . $addition;
    }

    /**
     * String Splitting
     *
     * Split a string into parts based on a delimiter. Operates similar to php `explode`,
     * but is more consistent. Can split on empty delimiters, and trims out empty strings
     * after exploding.
     *
     * ```
     * $split('-', 'Hello-World'); // ['Hello', 'World']
     * $split('', 'asdf'); // ['a', 's', 'd', 'f']
     * $split('-', 'foo-bar-'); ['foo', 'bar']
     * ```
     *
     * @type String -> String -> [String]
     *
     * @param  String $on     Split delimiter
     * @param  String $string Thing to split into pieces
     * @return array          List of chunks from splitting the string
     */
    protected static function split($on, $string)
    {
        if ($on === '')
            return str_split($string);

        return array_filter(explode($on, $string));
    }

    /**
     * Substring Match
     *
     * Determines if a string starts with a specific substring. Returns true if the string
     * matches the substring at its start, otherwise false.
     *
     * ```
     * $startsWith('as', 'asdf'); true
     * $startsWith('foo', 'barfoo'); false
     * ```
     *
     * @type String -> String -> Bool
     *
     * @param  String $subStr Substring to test
     * @param  String $str    String to run test on
     * @return Bool           Whether or not the string starts with the substring
     */
    protected static function startsWith($subStr, $str)
    {
        return substr($str, 0, strlen($subStr)) === $subStr;
    }

    /**
     * Lowercase Conversion
     *
     * Converts a string to lowercase.
     *
     * ```
     * $toLowercase('ASdf'); // 'asdf'
     * ```
     *
     * @type String -> String
     *
     * @param  String $str Original string
     * @return String      Lowercase string
     */
    protected static function toLowercase($str)
    {
        return strtolower($str);
    }
    
    /**
     * Uppercase Conversion
     *
     * Converts a string to uppercase.
     *
     * ```
     * $toLowercase('asDf'); // 'ASDF'
     * ```
     * @type String -> String
     * 
     * @param  String $str Original string
     * @return String      Uppercase string
     */
    protected static function toUppercase($str)
    {
        return strtoupper($str);
    }

    /**
     * String Joining
     *
     * Joins an array of strings together with a given delimiter. Works similarly
     * to PHP `implode`. The inverse of `split`.
     *
     * ```
     * $join(' ', ['Hello', 'World']); // 'Hello World'
     * $join('', ['a', 's', 'd', 'f']); // 'asdf'
     * ```
     *
     * @type String -> [String] -> String
     *
     * @param  String $on     Delimiter to join on
     * @param  array  $string List of strings to join together
     * @return String         Joined string based on delimiter
     */
    protected static function join($on, $string)
    {
        return implode($on, $string);
    }
}
