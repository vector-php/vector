<?php

namespace Vector\Control;

use RecursiveArrayIterator;
use RecursiveIteratorIterator;
use ReflectionFunction;
use ReflectionParameter;
use Vector\Core\Exception\ElementNotFoundException;
use Vector\Core\Exception\IncompletePatternMatchException;
use Vector\Core\Module;
use Vector\Lib\Arrays;
use Vector\Typeclass\FunctorInterface;

/**
 * Class Pattern
 * @package Vector\Control
 * @method static mixed match(array $patterns)
 * @method static bool any()
 * @method static bool just()
 * @method static bool nothing()
 * @method static bool string()
 * @method static bool number()
 */
abstract class Pattern extends Module
{
    protected static function __getType($param)
    {
        $type = is_object($param)
            ? get_class($param)
            : gettype($param);

        return $type === 'integer' ? 'int' : $type;
    }

    /**
     * @param array $patterns
     * @return \Closure
     */
    protected static function __match(array $patterns)
    {
        return function (...$args) use ($patterns) {
            $parameterTypes = array_map(self::getType(), $args);

            $patternApplies = function ($pattern) use ($parameterTypes, $args) {
                // Handle explicit match
                if (is_array($pattern)) {
                    return $pattern[0] === $args;
                }

                $reflected = new ReflectionFunction($pattern);

                $patternParameterTypes = array_map(function (ReflectionParameter $parameter) {
                    if ($class = $parameter->getClass()) {
                        return $class->getName();
                    } elseif ($type = $parameter->getType()) {
                        return $type->getName();
                    }

                    return null;
                }, $reflected->getParameters());

                // check count of params, then types of params
                return count($patternParameterTypes) === 0
                    || (
                        count($parameterTypes) === count($patternParameterTypes)
                        && $parameterTypes === $patternParameterTypes
                    );
            };

            try {
                $unwrappedArgs = self::flatten(array_map(function ($arg) {
                    return $arg instanceof FunctorInterface
                        ? $arg->extract()
                        : $arg;
                }, $args));

                $matchingPattern = Arrays::first($patternApplies, $patterns);

                if (is_array($matchingPattern)) {
                    $value = $matchingPattern[1](...$args);

                    if (is_callable($value)) {
                        return $value(...$unwrappedArgs);
                    } else {
                        return $value;
                    }
                } else {
                    $value = $matchingPattern(...$args);

                    if (is_callable($value)) {
                        return $value(...$unwrappedArgs);
                    } else {
                        return $value;
                    }
                }
            } catch (ElementNotFoundException $e) {
                throw new IncompletePatternMatchException('Incomplete pattern match expression.');
            }
        };
    }

    private static function flatten(array $array)
    {
        $values = [];

        array_walk_recursive(
            $array,
            function ($value) use (&$values) {
                $values[] = $value;
            }
        );

        return $values;
    }
}
