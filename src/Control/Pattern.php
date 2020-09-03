<?php

namespace Vector\Control;

use ReflectionClass;
use ReflectionFunction;
use ReflectionParameter;
use Vector\Core\Exception\ElementNotFoundException;
use Vector\Core\Exception\IncompletePatternMatchException;
use Vector\Core\Module;
use Vector\Lib\Arrays;

/**
 * @method static mixed match(...$args)
 */
abstract class Pattern extends Module
{
    /**
     * Get type OR class for params, as well as re-mapping inconsistencies
     * @param $param
     * @return string
     */
    protected static function __getType($param)
    {
        $type = is_object($param)
            ? get_class($param)
            : gettype($param);

        return $type === 'integer' ? 'int' : $type;
    }

    /**
     * Pattern Matching. Use switch-case for explicit values, this for everything else.
     * @param array $patterns
     * @return mixed
     */
    protected static function __match(array $patterns)
    {
        return function (...$args) use ($patterns) {
            $parameterTypes = array_map(self::getType(), $args);

            try {
                $keysToValues = Arrays::zip(array_keys($patterns), array_values($patterns));

                list($key, $matchingPattern) = Arrays::first(
                    Pattern::patternApplies($parameterTypes, $args),
                    $keysToValues
                );
            } catch (ElementNotFoundException $e) {
                throw new IncompletePatternMatchException(
                    'Incomplete pattern match expression. (missing ' . implode(', ', $parameterTypes) . ')'
                );
            }

            list($hasExtractable, $unwrappedArgs) = self::unwrapArgs($args);

            $value = $matchingPattern(...$args);
            $isCallable = is_callable($value);

            /**
             * Extractable requires a callback to feed args into.
             */
            if ($hasExtractable && $isCallable) {
                return $matchingPattern(...$args)(...$unwrappedArgs);
            }

            /**
             * No extractable or callable so we can just return the value directly.
             */
            return $value;
        };
    }

    /**
     * Extracts args from Extractable values
     * @param array $args
     * @return array
     */
    protected static function unwrapArgs(array $args) : array
    {
        $hasExtractable = false;

        $unwrappedArgs = self::flatten(array_map(function ($arg) use (&$hasExtractable) {
            if (is_object($arg) && method_exists($arg, 'extract')) {
                $hasExtractable = true;
                return $arg->extract();
            }

            return $arg;
        }, $args));

        return [$hasExtractable, $unwrappedArgs];
    }

    /**
     * @param array $parameterTypes
     * @param array $args
     * @param array $pattern
     * @return bool
     * @throws \ReflectionException
     */
    protected static function __patternApplies(array $parameterTypes, array $args, array $pattern) : bool
    {
        list($key, $pattern) = $pattern;

        $reflected = new ReflectionFunction($pattern);

        $patternParameterTypes = array_map(function (ReflectionParameter $parameter) {
            $class = $parameter->getType() && !$parameter->getType()->isBuiltin()
                ? new ReflectionClass($parameter->getType()->getName())
                : null;
            if ($class) {
                return $class->getName();
            }

            return (string) ($parameter->getType() ? $parameter->getType()->getName() : null);
        }, $reflected->getParameters());

        /**
         * Check count/type of params
         */
        return count($patternParameterTypes) === 0
            || (
                count($parameterTypes) === count($patternParameterTypes)
                && $parameterTypes === $patternParameterTypes
            );
    }

    /**
     * @param array $array
     * @return array
     */
    private static function flatten(array $array) : array
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
