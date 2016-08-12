<?php

namespace Vector\Control;

use Vector\Core\Module;
use Vector\Lib\Lambda;
use Vector\Typeclass\FunctorInterface as TypeclassFunctor;

/**
 * Class Functor
 * @package Vector\Control
 * @method static array fmap($f, $container)
 */
abstract class Functor extends Module
{
    protected static function __fmap($f, $container)
    {
        // If $container is a simple array, just defer to array_map
        if (is_array($container))
            return array_map($f, $container);

        // If $container is a function, we defer to compose
        if ($container instanceof \Closure) {
            return Lambda::compose($f, $container);
        }

        // If $container implements the Traversable interface, we can foreach over it
        if ($container instanceof \Traversable) {
            $result = [];

            foreach ($container as $item)
                $result[] = $f($item);

            return $result;
        }

        // Otherwise we just need to defer to the instances' internal fmap definition
        return $container->fmap($f);
    }

    protected static function __extract(TypeclassFunctor $f)
    {
        return $f->extract();
    }
}
