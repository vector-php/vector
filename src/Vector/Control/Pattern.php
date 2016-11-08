<?php

namespace Vector\Control;

use Vector\Control\Exception\IncompletePatternMatchException;
use Vector\Core\Module;

use Vector\Lib\{
    ArrayList,
    Logic,
    Lambda
};

/**
 * Class Pattern
 * @package Vector\Control
 * @method static mixed match(array $patterns)
 * @method static bool any()
 * @method static mixed make($pattern)
 * @method static bool string($pattern)
 * @method static bool number($pattern)
 */
abstract class Pattern extends Module
{
    const _ = 'ANY_PATTERN_PLACEHOLDER_CHARACTER';

    /**
     * @param $pattern
     * @return mixed
     */
    protected static function __make($pattern)
    {
        if ($pattern === self::_) {
            return self::any();
        }

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

    /**
     * @param array $patterns
     * @return \Closure
     */
    protected static function __match(array $patterns)
    {
        return function (...$args) use ($patterns) {
            // [a] -> Bool
            $patternApplies = function ($pattern) use ($args) {
                /** @noinspection PhpParamsInspection */
                return Logic::all(
                    ArrayList::zipWith(
                        Lambda::apply(),
                        ArrayList::map(
                            self::make(),
                            ArrayList::init($pattern)
                        ),
                        $args
                    )
                );
            };

            try {
                /** @noinspection PhpParamsInspection */
                $getMatchedImplementation = Lambda::compose(
                    ArrayList::last(),
                    ArrayList::first($patternApplies),
                    ArrayList::filter(function ($pattern) use ($args) {
                        return (count($pattern) - 1) === (count($args));
                    })
                );

                return call_user_func_array(
                    $getMatchedImplementation($patterns),
                    $args
                );
            } catch (\Exception $e) {
                throw new IncompletePatternMatchException('Incomplete pattern match expression.');
            }
        };
    }

    /**
     * @param $pattern
     * @param $subject
     * @return bool
     */
    protected static function __number($pattern, $subject)
    {
        return is_numeric($subject) && $pattern == $subject;
    }

    /**
     * @param $pattern
     * @param $subject
     * @return bool
     */
    protected static function __string($pattern, $subject)
    {
        return is_string($subject) && $pattern == $subject;
    }

    /**
     * @param $pattern
     * @param $subject
     * @return bool
     */
    protected static function __any($pattern, $subject)
    {
        return true;
    }
}
