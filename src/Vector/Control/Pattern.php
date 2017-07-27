<?php

namespace Vector\Control;

use ReflectionFunction;
use Vector\Core\Exception\ElementNotFoundException;
use Vector\Core\Exception\IncompletePatternMatchException;
use Vector\Core\Module;

use Vector\Data\Maybe;
use Vector\Lib\{
    Arrays, Logic, Lambda
};

/**
 * Class Pattern
 * @package Vector\Control
 * @method static mixed match(array $patterns)
 * @method static mixed make($pattern)
 * @method static bool any()
 * @method static bool just()
 * @method static bool nothing()
 * @method static bool string()
 * @method static bool number()
 */
abstract class Pattern extends Module
{
    /**
     * @param $pattern
     * @return mixed
     */
    protected static function __make($pattern)
    {
        switch (gettype($pattern)) {
            case 'string':
            case 'integer':
            case 'double':
            case 'array':
                return Logic::eqStrict($pattern);
            default:
                return $pattern;
        }
    }

    private static function checkPatterns(array $patterns)
    {
        foreach ($patterns as $patternAndCallback) {
            [$pattern, $callback] = $patternAndCallback;

            if (!is_callable($pattern)) {
                throw new \InvalidArgumentException('Invalid pattern. Patterns must be callables. Maybe you meant `Logic::eq()`?');
            }

            if (!is_callable($callback)) {
                throw new \InvalidArgumentException('Invalid callback for pattern.');
            }
        }
    }

    /**
     * @param array $patterns
     * @return \Closure
     */
    protected static function __match(array $patterns)
    {
        return function (...$args) use ($patterns) {
            self::checkPatterns($patterns);

            $patternApplies = function ($patternAndCallback) use ($args) {
                [$pattern, $callback] = $patternAndCallback;

                /** @noinspection PhpParamsInspection */
                return Logic::all(
                    Arrays::zipWith(
                        Lambda::apply(),
                        [self::make($pattern)],
                        $args
                    )
                );
            };

            try {
                /** @noinspection PhpParamsInspection */
                $getMatchedPatternAndImplementation = Lambda::compose(
                    Arrays::first($patternApplies),
                    Arrays::filter(function ($pattern) use ($args) {
                        return (count($pattern) - 1) === (count($args));
                    })
                );

                [$matchedPattern, $matchedImplementation] = $getMatchedPatternAndImplementation($patterns);

                /**
                 * Extract Just
                 */
                if ((new ReflectionFunction($matchedPattern))->getStaticVariables()['f'][1] === '__just') {
                    return $matchedImplementation($args[0]->extract());
                }

                return call_user_func_array(
                    $matchedImplementation,
                    $args
                );
            } catch (ElementNotFoundException $e) {
                throw new IncompletePatternMatchException('Incomplete pattern match expression.');
            }
        };
    }

    /**
     * @param $subject
     * @param $pattern
     * @return bool
     * @internal param $pattern
     * @internal param $subject
     */
    protected static function __number($subject, $pattern)
    {
        return Type::number($subject) && $pattern === $subject;
    }

    /**
     * @param $subject
     * @param $pattern
     * @return bool
     * @internal param $pattern
     * @internal param $subject
     */
    protected static function __string($subject, $pattern)
    {
        return Type::string($subject) && $pattern === $subject;
    }

    /**
     * @param $subject
     * @param $pattern
     * @return bool
     * @internal param $pattern
     * @internal param $subject
     */
    protected static function __array($subject, $pattern)
    {
        return Type::array($subject) && $pattern === $subject;
    }

    /**
     * @param $subject
     * @return bool
     * @internal param $pattern
     * @internal param $subject
     */
    protected static function __just($subject)
    {
        return Type::just($subject);
    }

    /**
     * @param $subject
     * @return bool
     * @internal param $pattern
     * @internal param $subject
     */
    protected static function __nothing($subject)
    {
        return Type::nothing($subject);
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
