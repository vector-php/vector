<?php

namespace Vector\Control;

use Vector\Core\FunctionCapsule;

use Vector\Data\Identity;
use Vector\Data\Constant;

use Vector\Lib\Functor;
use Vector\Lib\Lambda;
use Vector\Lib\List;

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
        $curry = FunctionCapsule::Using('curry');

        $indexLens = $curry(function($index, $f, $arr) {
            $fmap = Functor::Using('fmap');
            $set  = List::Using('set');

            return $fmap($set($index, $arr), $f($arr[$index]));
        });

        return $indexLens($index);
    }
}
