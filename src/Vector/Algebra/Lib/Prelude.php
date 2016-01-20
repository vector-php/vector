<?php

namespace Vector\Algebra\Lib;

class Prelude
{
    public static function usingAll()
    {
        return [
            'compose' => Lambda::using('compose'),
            'map' => Functor::using('fmap'),
            'extract' => Functor::using('extract'),
            'bind' => Monad::using('bind')
        ];
    }
}