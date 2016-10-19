<?php

namespace Vector\Test\Data\Generic;

use Vector\Data\Constant;
use Vector\Control\Applicative;
use Vector\Lib\Lambda;

class ApplicativeLaws extends \PHPUnit_Framework_TestCase
{
    protected $testCases;
    protected $applicativeContext;

    /**
     * Tests the applicative identity law.
     * pure id <*> f = f
     */
    public function testApplicativeLawIdentity()
    {
        foreach ($this->testCases as $testFunctor) {
            $this->assertEquals(
                Applicative::apply(
                    Applicative::pure($this->applicativeContext, Lambda::id()),
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
            $f = function($n) { return $n + 1; };
            $x = 4;

            $this->assertEquals(
                Applicative::apply(
                    Applicative::pure($this->applicativeContext, $f),
                    Applicative::pure($this->applicativeContext, $x)
                ),
                Applicative::pure($this->applicativeContext, $f($x))
            );
        }
    }
}
