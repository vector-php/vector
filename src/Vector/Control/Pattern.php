<?php

namespace Vector\Control;

use Vector\Core\Module;

use Vector\Lib\{
    ArrayList,
    Logic,
    Lambda
};

abstract class Pattern extends Module
{
    protected static function __makePattern($pattern)
    {
        switch (gettype($pattern)) {
            case 'string':
                return self::string($pattern);
            case 'integer':
            case 'double':
                return self::number($pattern);
            default:
                return $pattern;
        }
    }

    protected static function __patternMatch($patterns)
    {
        return function(...$args) use ($patterns) {
            // [a] -> Bool
            $patternApplies = function($pattern) use ($args) {
                return Logic::all(
                    ArrayList::zipWith(
                        Lambda::apply(), ArrayList::map(self::makePattern(), ArrayList::init($pattern)), ...$args
                    )
                );
            };

            try {
                return call_user_func_array(Lambda::compose(ArrayList::last(), ArrayList::first($patternApplies))($patterns), ...$args);
            } catch (\Exception $e) {
                // @todo Convert ElementNotFound exceptions into IncompletePatternMatch exceptions
                throw new \Exception('Incomplete pattern match expression.');
            }
        };
    }

    protected static function __number($pattern, $subject)
    {
        return is_numeric($subject) && $pattern == $subject;
    }

    protected static function __string($pattern, $subject)
    {
        return is_string($subject) && $pattern == $subject;
    }

    protected static function __any($pattern, $subject)
    {
        return true;
    }
}
