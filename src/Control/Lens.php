<?php

namespace Vector\Control;

use Vector\Core\FunctionCapsule;

use Vector\Data\Identity;
use Vector\Data\Constant;

use Vector\Lib\Functor;
use Vector\Lib\Lambda;

class Lens extends FunctionCapsule
{
    protected static function constant($a)
    {
        return Constant::Constant($a);
    }

    protected static function identity($a)
    {
        return Identity::Identity($a);
    }

    protected static function setIndexVal($key, $obj, $val)
    {
        $obj[$key] = $val; return $obj;
    }

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
        $indexLens = self::Using('__indexLens');

        return $indexLens($index);
    }

    // TODO:
    // Manually pull in $curry and curry this privately so it's not exposed globally for everyone
    // to shoot themselves in the foot with.
    protected static function __indexLens($index, $f, $arr)
    {
        $fmap = Functor::Using('fmap');
        $set  = self::Using('setIndexVal');

        return $fmap($set($index, $arr), $f($arr[$index]));
    }
}
