<?php

namespace Vector\Control;

use Vector\Core\Module;

use Vector\Data\Identity;
use Vector\Data\Constant;

use Vector\Lib\Lambda;
use Vector\Lib\ArrayList;
use Vector\Lib\Object;

class Lens extends Module
{
    protected static function __constant($a)
    {
        return Constant::Constant($a);
    }

    protected static function __identity($a)
    {
        return Identity::Identity($a);
    }

    /**
     * View
     *
     * View an object or array through a lens. Simply applies your lens - the
     * behavior of this function will vary slightly depending on the particular
     * lens that you're using.
     *
     * ```
     * $myLens = $indexLens('a');
     * $view($myLens, ['a' => 'b']); // b
     * ```
     *
     * !!! Note
     *     Depending on which lens you use, this method might throw an exception.
     *     Refer to the indivual lenses to see if they're safe to use or not.
     *
     * @param  Lens  $lens Lens to use when viewing an object
     * @param  Mixed $x    Object or array to view
     * @return Mixed       The property that the lens focused on
     */
    protected static function __viewL(callable $lens, $x)
    {
        $compose   = Lambda::Using('compose');
        $makeConst = self::Using('constant');
        $runConst  = Functor::Using('extract');

        $view = $compose(
            $runConst,
            $lens($makeConst)
        );

        return $view($x);
    }

    protected static function __overL($lens, $f, $x)
    {
        $compose   = Lambda::Using('compose');
        $makeIdent = self::Using('identity');
        $runIdent  = Functor::Using('extract');

        $setter = $compose($makeIdent, $f);

        $over = $compose(
            $runIdent,
            $lens($setter)
        );

        return $over($x);
    }

    protected static function __setL($lens, $v, $x)
    {
        $k    = Lambda::Using('k');
        $over = self::Using('overL');

        return $over($lens, $k($v), $x);
    }

    protected static function __indexLens($index)
    {
        $arraySetter = Module::curry(function($i, $arr, $val) {
            $arr[$i] = $val; return $arr;
        });

        $indexLens = self::makeLens(ArrayList::index(), $arraySetter);

        return $indexLens($index);
    }

    protected static function __propLens($prop)
    {
        $objectSetter = Module::curry(function($k, $objO, $val) {
            $obj = clone $objO; $obj->$k = $val; return $obj;
        });

        $propLens = self::makeLens(Object::getProp(), $objectSetter);

        return $propLens($prop);
    }

    protected static function __indexLensSafe($index)
    {
        $arraySetter = Module::curry(function($i, $arr, $val) {
            $arr[$i] = $val; return $arr;
        });

        $safeGetter = function($index, $arr) {
            if ($arr === null)
                return null;
            else if (isset($arr[$index])) {
                return $arr[$index];
            }
            else
                return null;
        };

        $indexLens = self::makeLens($safeGetter, $arraySetter);

        return $indexLens($index);
    }

    protected static function __pathLens($path)
    {
        return Lambda::compose(...Functor::fmap(function($index) { return self::indexLens($index); }, $path));
    }

    protected static function __pathLensSafe($path)
    {
        return Lambda::compose(...Functor::fmap(function($index) { return self::indexLensSafe($index); }, $path));
    }

    private static function makeLens($getter, $setter)
    {
        return Module::curry(function($key, $f, $inv) use ($getter, $setter) {
            return Functor::fmap($setter($key, $inv), $f($getter($key, $inv)));
        });
    }
}
