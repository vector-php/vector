<?php

class MaybeTest extends PHPUnit_Framework_TestCase
{
    public function testMaybeExtractNothingIsNull()
    {
        $extract = \Vector\Algebra\Lib\Functor::using('extract');
        $value = \Vector\Algebra\Monad\Maybe::Nothing();

        $this->assertNull($extract($value));
    }
}