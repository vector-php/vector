<?php

namespace Vector\Lib;

use Vector\Core\Module;

/**
 * @method static string concat() contact(string $a, string $b) Concatenates the first argument to the second argument.
 * @method static array split() split(string $delimiter, string $string) Split a string into parts based on a delimiter. Operates similar to php `explode`.
 * @method static string startsWith() startsWith(string $substring, string $string) Determines if a string starts with a specific substring.
 * @method static string toLowercase() toLowercase(string $string) Converts a string to lowercase.
 * @method static string toUppercase() toUppercase(string $string) Converts a string to uppercase.
 * @method static string trim() trim(string $string) Removes all leading and trailing whitespace from a string.
 * @method static string join() join(string $string) Joins an array of strings together with a given delimiter.
 */
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
    protected static function __concat($addition, $original)
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
    protected static function __split($on, $string)
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
    protected static function __startsWith($subStr, $str)
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
    protected static function __toLowercase($str)
    {
        return strtolower($str);
    }

    /**
     * Uppercase Conversion
     *
     * Converts a string to uppercase.
     *
     * ```
     * $toUppercase('asdf'); // 'ASDF'
     * ```
     *
     * @type String -> String
     *
     * @param  String $str Original string
     * @return String      Uppercase string
     */
    protected static function __toUppercase($str)
    {
        return strtoupper($str);
    }

    /**
     * Trim Whitespace
     *
     * Removes all leading and trailing whitespace from a string. Defers to
     * PHP trim.
     *
     * ```
     * $trim(' asdf '); // 'asdf'
     * ```
     *
     * @type String -> String
     *
     * @param  String $str string to trim
     * @return string
     */
    protected static function __trim($str)
    {
        return trim($str);
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
    protected static function __join($on, $string)
    {
        return implode($on, $string);
    }
}
