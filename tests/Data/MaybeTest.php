<?php

namespace Vector\Test\Data;

use Vector\Data\Maybe\Maybe;
use Vector\Test\Data\Generic\ApplicativeLaws;

/**
 * Class MaybeTest
 * @package Vector\Test\Data
 */
class MaybeTest extends ApplicativeLaws
{
    public function setUp()
    {
        /**
         * Used for ApplicativeLaws
         */
        $this->testCases = [
            Maybe::just(7),
            Maybe::nothing(),
        ];
    }
}
