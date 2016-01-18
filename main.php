<?php

use Vector\Util\FunctionCapsule;

use Vector\Algebra\Monad\Maybe;
use Vector\Algebra\Monad\Reader;

use Vector\Algebra\Lib\Reader as ReaderLib;
use Vector\Algebra\Lib\Monad;
use Vector\Algebra\Lib\Lambda;

require(__DIR__ . '/vendor/autoload.php');

class App extends FunctionCapsule
{
    // verifyUser :: UserID -> Bool
    protected static function verifyUser($user)
    {
        return $user == 1;
    }

    // saveData :: Reader Data Bool
    protected static function saveData()
    {
        $ask  = ReaderLib::using('ask');
        $bind = Monad::using('bind');

        return $bind(function($request) {
            return Reader::pure($request['data'] == 'FooBar');
        }, $ask);
    }

    // postSave :: Reader Error Response
    protected static function postSave()
    {
        $ask                         = ReaderLib::using('ask');
        $compose                     = Lambda::using('compose');
        list($verifyUser, $saveData) = self::using('verifyUser', 'saveData');

        return
    }
}

$runReader = ReaderLib::using('runReader');
$postSave  = App::using('postSave');

var_dump($runReader($postSave(), ['user' => 1, 'data' => 'FooBar']));