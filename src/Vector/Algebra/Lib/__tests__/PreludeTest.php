<?php

namespace Vector\Algebra\Lib\__tests__;

use Closure;
use Vector\Algebra\Lib\Prelude;

class PreludeTest extends \PHPUnit_Framework_TestCase
{
    public function testPrelude()
    {
        extract(Prelude::usingAll());

        /** @var closure $map */
        /** @var closure $bind */
        /** @var closure $extract */
        /** @var closure $compose */
        /** @var closure $pure */

        $this->assertInstanceOf('closure', $map);
        $this->assertInstanceOf('closure', $bind);
        $this->assertInstanceOf('closure', $extract);
        $this->assertInstanceOf('closure', $compose);
        $this->assertInstanceOf('closure', $pure);
    }
}