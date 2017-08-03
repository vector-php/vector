<?php

namespace Vector\Test\Data;

use Vector\Data\Either\Either;
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
            Either::left("error message"),
            Either::right(7),
        ];

        $this->applicativeContext = Either::class;
    }
}
