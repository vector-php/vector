<?php

namespace Vector\Typeclass;

/**
 * @method static callable map($value)
 */
interface FunctorInterface
{
    public static function __map(callable $f, FunctorInterface $value);
    public function extract();
}
