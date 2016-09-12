<?php

namespace Vector\Control;

use Vector\Core\Module;

use Vector\Data\Identity;
use Vector\Data\Constant;

use Vector\Lib\Lambda;
use Vector\Lib\ArrayList;
use Vector\Lib\Object;

/**
 * Class Lens
 * @package Vector\Control
 * @method static callable indexLens(mixed $index)
 * @method static callable indexLensSafe(mixed $index)
 * @method static callable propLens(string $prop)
 * @method static callable propLensSafe(string $prop)
 * @method static callable pathLens(array $path)
 * @method static callable pathLensSafe(array $path)
 * @method static callable viewL(callable $lens, mixed $x)
 */
class Lens extends Module
{
    /**
     * View
     *
     * View an object or array through a lens. Simply applies your lens - the
     * behavior of this function will vary slightly depending on the particular
     * lens that you're using.
     *
     * @example
     * $myLens = Lens::indexLens('a');
     * Lens::viewL($myLens, ['a' => 'b']); // b
     *
     * @note Depending on which lens you use, this method might throw an exception.
     *       Refer to the indivual lenses to see if they're safe to use or not.
     *
     * @param callable|Lens $lens Lens to use when viewing an object
     * @param  Mixed $x Object or array to view
     * @return mixed The property that the lens focused on
     * @internal param Lens $ a -> a
     */
    protected static function __viewL(callable $lens, $x)
    {
        $view = Lambda::compose(
            Functor::extract(),
            $lens(Constant::constant())
        );

        return $view($x);
    }

    protected static function __overL($lens, $f, $x)
    {
        $over = Lambda::compose(
            Functor::extract(),
            $lens(Lambda::compose(Identity::identity(), $f))
        );

        return $over($x);
    }

    protected static function __setL($lens, $v, $x)
    {
        return self::overL($lens, Lambda::k($v), $x);
    }

    protected static function __indexLens($index)
    {
        $arraySetter = Module::curry(function ($i, $arr, $val) {
            $arr[$i] = $val;
            return $arr;
        });

        /** @noinspection PhpParamsInspection */
        $indexLens = self::makeLens(ArrayList::index(), $arraySetter);

        return $indexLens($index);
    }

    protected static function __propLens($prop)
    {
        $objectSetter = Module::curry(function ($k, $objO, $val) {
            $obj = clone $objO;
            $obj->{$k} = $val;
            return $obj;
        });

        /** @noinspection PhpParamsInspection */
        $propLens = self::makeLens(Object::getProp(), $objectSetter);

        return $propLens($prop);
    }

    protected static function __propLensSafe($prop)
    {
        $objectSetter = Module::curry(function ($k, $objO, $val) {
            $obj = clone $objO;
            $obj->{$k} = $val;
            return $obj;
        });

        $safeGetter = function ($prop, $obj) {
            if ($obj === null) {
                return null;
            } elseif (isset($obj->{$prop})) {
                return $obj->{$prop};
            }

            return null;
        };

        $propLens = self::makeLens($safeGetter, $objectSetter);

        return $propLens($prop);
    }

    protected static function __indexLensSafe($index)
    {
        $arraySetter = Module::curry(function ($i, $arr, $val) {
            $arr[$i] = $val;
            return $arr;
        });

        $safeGetter = function ($index, $arr) {
            if ($arr === null) {
                return null;
            } elseif (isset($arr[$index])) {
                return $arr[$index];
            }

            return null;
        };

        $indexLens = self::makeLens($safeGetter, $arraySetter);

        return $indexLens($index);
    }

    protected static function __pathLens($path)
    {
        return Lambda::compose(...Functor::fmap(function ($index) {
            return self::indexLens($index);
        }, $path));
    }

    protected static function __pathLensSafe($path)
    {
        return Lambda::compose(...Functor::fmap(function ($index) {
            return self::indexLensSafe($index);
        }, $path));
    }

    protected static function __pathPropLens($path)
    {
        return Lambda::compose(...Functor::fmap(function ($index) {
            return self::propLens($index);
        }, $path));
    }

    protected static function __pathPropLensSafe($path)
    {
        return Lambda::compose(...Functor::fmap(function ($index) {
            return self::propLensSafe($index);
        }, $path));
    }

    private static function makeLens($getter, $setter)
    {
        return Module::curry(function ($key, $f, $inv) use ($getter, $setter) {
            return Functor::fmap($setter($key, $inv), $f($getter($key, $inv)));
        });
    }
}
