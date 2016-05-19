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
    protected static function constant($a)
    {
        return Constant::Constant($a);
    }

    protected static function identity($a)
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
    protected static function view($lens, $x)
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

    protected static function over($lens, $f, $x)
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

    protected static function set($lens, $v, $x)
    {
        $k    = Lambda::Using('k');
        $over = self::Using('over');

        return $over($lens, $k($v), $x);
    }

    protected static function indexLens($index)
    {
        $indexLens = self::makeLens(ArrayList::index(), ArrayList::set());

        return $indexLens($index);
    }

    protected static function propLens($prop)
    {
        $propLens = self::makeLens(Object::get(), Object::set());

        return $propLens($prop);
    }

    protected static function indexLensSafe($index)
    {
        $safeGetter = function($index, $arr) {
            if ($arr === null)
                return null;
            else if (isset($arr[$index])) {
                return $arr[$index];
            }
            else
                return null;
        };

        $indexLens = self::makeLens($safeGetter, ArrayList::set());

        return $indexLens($index);
    }

    protected static function pathLens($path)
    {
        return Lambda::compose(...Functor::fmap(function($index) { return self::indexLens($index); }, $path));
    }

    protected static function pathLensSafe($path)
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
