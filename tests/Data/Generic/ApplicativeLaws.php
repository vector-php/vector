<?php

namespace Vector\Test\Data\Generic;

use Vector\Data\Constant;
use Vector\Control\Applicative;
use Vector\Lib\Lambda;

/**
 * Class ApplicativeLaws
 * @package Vector\Test\Data\Generic
 */
class ApplicativeLaws extends \PHPUnit_Framework_TestCase
{
    protected $testCases;

    /**
     * Tests the applicative identity law.
     * pure id <*> f = f
     */
    public function testApplicativeLawIdentity()
    {
        foreach ($this->testCases as $testFunctor) {
            $applicativeContext = get_class($testFunctor);

            $this->assertEquals(
                Applicative::apply(
                    Applicative::pure($applicativeContext, Lambda::id()),
                    $testFunctor
                ),
                $testFunctor
            );
        }
    }

    /**
     * Tests the applicative homomorphism law.
     * pure f <*> pure x = pure (f x)
     */
    public function testApplicativeLawHomomorphism()
    {
        foreach ($this->testCases as $testFunctor) {
            $f = function ($n) {
                return $n + 1;
            };
            $x = 4;

            $applicativeContext = get_class($testFunctor);

            $this->assertEquals(
                Applicative::apply(
                    Applicative::pure($applicativeContext, $f),
                    Applicative::pure($applicativeContext, $x)
                ),
                Applicative::pure($applicativeContext, $f($x))
            );
        }
    }
}
