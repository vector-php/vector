<?php

namespace Vector\Lib;

use Vector\Core\Module;

/**
 * @method static string contact(string $a, string $b) Concatenates the first argument to the second argument.
 * @method static array split(string $delimiter, string $string) Split a string into parts based on a delimiter. Operates similar to php `explode`.
 * @method static string startsWith(string $substring, string $string) Determines if a string starts with a specific substring.
 * @method static string toLowercase(string $string) Converts a string to lowercase.
 * @method static string toUppercase(string $string) Converts a string to uppercase.
 * @method static string trim(string $string) Removes all leading and trailing whitespace from a string.
 * @method static string lchomp(string $string, string $toChomp) Removes the specified string from the left end of the target string.
 * @method static string rchomp(string $string, string $toChomp) Removes the specified string from thr right end of the target string.
 * @method static string chomp(string $string, string $toChomp) Removes the specified string from both ends of the target string.
 * @method static string join(string $string) Joins an array of strings together with a given delimiter.
 * @method static string replace(string $substring, string $replacement, string $string) Replace all occurrences of the search string with the replacement string.
 */
class Strings extends Module
{
    /**
     * String Concatenation
     *
     * Concatenates the first argument to the second argument, provided both arguments
     * are strings. Defers to the PHP built-in concatenation.
     *
     * @example
     * Strings::concat('as', 'df'); // 'dfas'
     *
     * @example
     * Strings::concat('World', $concat('ello', 'H')); // 'HelloWorld'
     *
     * @type String -> String -> String
     *
     * @param  String $addition Thing to append
     * @param  String $original Thing to append to
     * @return String           Concatenated strings
     */
    protected static function __concat(string $addition, string $original) : string
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
     * @example
     * Strings::split('-', 'Hello-World'); // ['Hello', 'World']
     *
     * @example
     * Strings::split('', 'asdf'); // ['a', 's', 'd', 'f']
     *
     * @example
     * Strings::split('-', 'foo-bar-'); ['foo', 'bar']
     *
     * @type String -> String -> [String]
     *
     * @param  String $on     Split delimiter
     * @param  String $string Thing to split into pieces
     * @return array          List of chunks from splitting the string
     */
    protected static function __split(string $on, string $string) : array
    {
        if ($on === '') {
            return str_split($string);
        }

        return array_filter(explode($on, $string));
    }

    /**
     * Substring Match
     *
     * Determines if a string starts with a specific substring. Returns true if the string
     * matches the substring at its start, otherwise false.
     *
     * @example
     * Strings::startsWith('as', 'asdf'); true
     *
     * @example
     * Strings::startsWith('foo', 'barfoo'); false
     *
     * @type String -> String -> Bool
     *
     * @param  String $subStr Substring to test
     * @param  String $str    String to run test on
     * @return Bool           Whether or not the string starts with the substring
     */
    protected static function __startsWith(string $subStr, string $str) : bool
    {
        return substr($str, 0, strlen($subStr)) === $subStr;
    }

    /**
     * Lowercase Conversion
     *
     * Converts a string to lowercase.
     *
     * @example
     * Strings::toLowercase('ASdf'); // 'asdf'
     *
     * @type String -> String
     *
     * @param  String $str Original string
     * @return String      Lowercase string
     */
    protected static function __toLowercase(string $str) : string
    {
        return strtolower($str);
    }

    /**
     * Uppercase Conversion
     *
     * Converts a string to uppercase.
     *
     * @example
     * Strings::toUppercase('asdf'); // 'ASDF'
     *
     * @type String -> String
     *
     * @param  String $str Original string
     * @return String      Uppercase string
     */
    protected static function __toUppercase(string $str) : string
    {
        return strtoupper($str);
    }

    /**
     * Trim Whitespace
     *
     * Removes all leading and trailing whitespace from a string. Defers to
     * PHP trim.
     *
     * @example
     * Strings::trim(' asdf '); // 'asdf'
     *
     * @type String -> String
     *
     * @param  String $str string to trim
     * @return string
     */
    protected static function __trim(string $str) : string
    {
        return trim($str);
    }

    /**
     * Left Chomp
     *
     * Removes the specified substring from the left end of the target string. Unlike PHP's
     * trim function, the substring to chomp is not a character mask -- rather it is a full
     * substring. This function is case sensitive.
     *
     * @example
     * Strings::lchomp('He', 'Hello World'); // 'llo World'
     * Strings::lchomp('Hi', 'Hello World'); // 'Hello World'
     * Strings::lchomp('he', 'Hello World'); // 'Hello World'
     *
     * @type String -> String
     *
     * @param  String $toChomp string to chomp
     * @param  String $string string to be chomped
     * @return string
     */
    protected static function __lchomp(string $toChomp, string $string) : string
    {
        $length = strlen($toChomp);

        if (strcmp(substr($string, 0, $length), $toChomp) === 0) {
            return substr($string, $length);
        }

        return $string;
    }

    /**
     * Right Chomp
     *
     * Removes the specified substring from the right end of the target string. Unlike PHP's
     * trim function, the substring to chomp is not a character mask -- rather it is a full
     * substring. This function is case sensitive.
     *
     * @example
     * Strings::rchomp('ld', 'Hello World'); // 'Hello Wor'
     * Strings::rchomp('li', 'Hello World'); // 'Hello World'
     * Strings::rchomp('LD', 'Hello World'); // 'Hello World'
     *
     * @type String -> String
     *
     * @param  String $toChomp string to chomp
     * @param  String $string string to be chomped
     * @return string
     */
    protected static function __rchomp(string $toChomp, string $string) : string
    {
        $length = strlen($toChomp);

        if (strcmp(substr($string, -$length, $length), $toChomp) === 0) {
            $string = substr($string, 0, -$length);
        }

        return $string;
    }

    /**
     * Two-Sided Chomp
     *
     * Removes the specified substring from both ends of the target string. Unlike PHP's
     * trim function, the substring to chomp is not a character mask -- rather it is a full
     * substring. This function is case sensitive.
     *
     * @example
     * Strings::chomp('a', 'abccba'); // 'bccb'
     * Strings::chomp('ab', 'abccba'); // 'abccba'
     * Strings::chomp('A', 'abccba'); // 'abccba'
     *
     * @type String -> String
     *
     * @param  String $toChomp string to chomp
     * @param  String $string string to be chomped
     * @return string
     */
    protected static function __chomp(string $toChomp, string $string) : string
    {
        /** @noinspection PhpParamsInspection */
        $chomp = Lambda::compose(self::lchomp($toChomp), self::rchomp($toChomp));

        return $chomp($string);
    }

    /**
     * String Joining
     *
     * Joins an array of strings together with a given delimiter. Works similarly
     * to PHP `implode`. The inverse of `split`.
     *
     * @example
     * Strings::join(' ', ['Hello', 'World']); // 'Hello World'
     *
     * @example
     * Strings::join('', ['a', 's', 'd', 'f']); // 'asdf'
     *
     * @type String -> [String] -> String
     *
     * @param  String $on     Delimiter to join on
     * @param  array  $string List of strings to join together
     * @return String         Joined string based on delimiter
     */
    protected static function __join(string $on, array $string) : string
    {
        return implode($on, $string);
    }

    /**
     * String Replace
     *
     * Replace all occurrences of the search string with the replacement string.
     *
     * @example
     * Strings::replace('test', 'passes', 'this test']); // 'this passes'
     *
     * @param  String $substring Substring to find
     * @param $replacement
     * @param  String $string Replacement string
     * @return String $string Result after replacement
     * @internal param String $ -> String -> String
     *
     */
    protected static function __replace(string $substring, string $replacement, string $string) : string
    {
        return str_replace($substring, $replacement, $string);
    }
}
