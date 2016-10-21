<?php

namespace Vector\Test\Data;

use Vector\Data\Either;
use Vector\Data\Maybe;
use Vector\Test\Data\Generic\ApplicativeLaws;

/**
 * Class EitherTest
 * @package Vector\Test\Data
 */
class EitherTest extends ApplicativeLaws
{
    public function setUp()
    {
        /**
         * Used for ApplicativeLaws
         */
        $this->testCases = [
            Either::pure(7),
            Either::left(7),
            Either::right(7),
        ];

        $this->applicativeContext = Either::class;
    }
}
