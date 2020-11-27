<?php

namespace Vector\Test\Control;

use PHPUnit\Framework\TestCase;
use Vector\Lib\Arrays;
use Vector\Lib\Strings;

class VectorTest extends TestCase
{
    /** @test */
    function it_can_do_the_vector_pipe()
    {
        $example = vector(['a', 'b', 'c'])
            ->pipe(Strings::join(''))
            ->pipe(Strings::split('b'))
            ->pipe(Arrays::map(Strings::concat('!')))
            ->pipe(Strings::join(''));

        $this->assertEquals('a!c!', $example());
    }
}
