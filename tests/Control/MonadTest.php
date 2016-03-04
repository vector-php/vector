<?php

namespace Vector\Test\Control;

use Vector\Control\Monad;
use Vector\Lib\Strings;

class MonadTest extends \PHPUnit_Framework_TestCase
{
    public function testBind_arrayArgument()
    {
        $bind = Monad::using('bind');
        $split = Strings::using('split');

        $this->assertEquals(['a', 's', 'd', 'f'], $bind($split(''), ['as', 'df']));
    }
}
