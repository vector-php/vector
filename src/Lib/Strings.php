<?php

namespace Vector\Lib;

use Vector\Core\Module;

/**
 * @method static string concat(...$args)
 * @method static array split(...$args)
 * @method static string startsWith(...$args)
 * @method static string toLowercase(...$args)
 * @method static string toUppercase(...$args)
 * @method static string trim(...$args)
 * @method static string lchomp(...$args)
 * @method static string rchomp(...$args)
 * @method static string chomp(...$args)
 * @method static string join(...$args)
 * @method static string replace(...$args)
 */
class Strings
{
    use Module;

    /**
     * String Concatenation
     *
     * Concatenates the first argument to the second argument, provided both arguments
     * are strings. Defers to the PHP built-in concatenation.
     *
     * @param String $addition Thing to append
     * @param String $original Thing to append to
     * @return String           Concatenated strings
     * @example
     * Strings::concat('World', $concat('ello', 'H')); // 'HelloWorld'
     *
     * @type String -> String -> String
     *
     * @example
     * Strings::concat('as', 'df'); // 'dfas'
     *
     */
    protected static function __concat(string $addition, string $original): string
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
     * @param String $on Split delimiter
     * @param String $string Thing to split into pieces
     * @return array          List of chunks from splitting the string
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
     */
    protected static function __split(string $on, string $string): array
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
     * @param String $subStr Substring to test
     * @param String $str String to run test on
     * @return Bool           Whether or not the string starts with the substring
     * @example
     * Strings::startsWith('foo', 'barfoo'); false
     *
     * @type String -> String -> Bool
     *
     * @example
     * Strings::startsWith('as', 'asdf'); true
     *
     */
    protected static function __startsWith(string $subStr, string $str): bool
    {
        return substr($str, 0, strlen($subStr)) === $subStr;
    }

    /**
     * Lowercase Conversion
     *
     * Converts a string to lowercase.
     *
     * @param String $str Original string
     * @return String      Lowercase string
     * @example
     * Strings::toLowercase('ASdf'); // 'asdf'
     *
     * @type String -> String
     *
     */
    protected static function __toLowercase(string $str): string
    {
        return strtolower($str);
    }

    /**
     * Uppercase Conversion
     *
     * Converts a string to uppercase.
     *
     * @param String $str Original string
     * @return String      Uppercase string
     * @example
     * Strings::toUppercase('asdf'); // 'ASDF'
     *
     * @type String -> String
     *
     */
    protected static function __toUppercase(string $str): string
    {
        return strtoupper($str);
    }

    /**
     * Trim Whitespace
     *
     * Removes all leading and trailing whitespace from a string. Defers to
     * PHP trim.
     *
     * @param String $str string to trim
     * @return string
     * @example
     * Strings::trim(' asdf '); // 'asdf'
     *
     * @type String -> String
     *
     */
    protected static function __trim(string $str): string
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
     * @param String $toChomp string to chomp
     * @param String $string string to be chomped
     * @return string
     * @example
     * Strings::lchomp('He', 'Hello World'); // 'llo World'
     * Strings::lchomp('Hi', 'Hello World'); // 'Hello World'
     * Strings::lchomp('he', 'Hello World'); // 'Hello World'
     *
     * @type String -> String
     *
     */
    protected static function __lchomp(string $toChomp, string $string): string
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
     * @param String $toChomp string to chomp
     * @param String $string string to be chomped
     * @return string
     * @example
     * Strings::rchomp('ld', 'Hello World'); // 'Hello Wor'
     * Strings::rchomp('li', 'Hello World'); // 'Hello World'
     * Strings::rchomp('LD', 'Hello World'); // 'Hello World'
     *
     * @type String -> String
     *
     */
    protected static function __rchomp(string $toChomp, string $string): string
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
     * @param String $toChomp string to chomp
     * @param String $string string to be chomped
     * @return string
     * @example
     * Strings::chomp('a', 'abccba'); // 'bccb'
     * Strings::chomp('ab', 'abccba'); // 'abccba'
     * Strings::chomp('A', 'abccba'); // 'abccba'
     *
     * @type String -> String
     *
     */
    protected static function __chomp(string $toChomp, string $string): string
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
     * @param String $on Delimiter to join on
     * @param array $string List of strings to join together
     * @return String         Joined string based on delimiter
     * @example
     * Strings::join('', ['a', 's', 'd', 'f']); // 'asdf'
     *
     * @type String -> [String] -> String
     *
     * @example
     * Strings::join(' ', ['Hello', 'World']); // 'Hello World'
     *
     */
    protected static function __join(string $on, array $string): string
    {
        return implode($on, $string);
    }

    /**
     * String Replace
     *
     * Replace all occurrences of the search string with the replacement string.
     *
     * @param String $substring Substring to find
     * @param $replacement
     * @param String $string Replacement string
     * @return String $string Result after replacement
     * @example
     * Strings::replace('test', 'passes', 'this test']); // 'this passes'
     *
     * @internal param String $ -> String -> String
     *
     */
    protected static function __replace(string $substring, string $replacement, string $string): string
    {
        return str_replace($substring, $replacement, $string);
    }
}
