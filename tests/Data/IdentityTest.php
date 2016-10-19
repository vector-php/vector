<?php

namespace Vector\Test\Data;

use Vector\Data\Constant;
use Vector\Control\Functor;
use Vector\Data\Identity;
use Vector\Test\Data\Generic\ApplicativeLaws;

/**
 * Class IdentityTest
 * @package Vector\Test\Data
 */
class IdentityTest extends ApplicativeLaws
{
    public function setUp()
    {
        /**
         * Used for ApplicativeLaws
         */
        $this->testCases = [
            Identity::identity(7)
        ];

        $this->applicativeContext = Identity::class;
    }

    /**
     * Test that identity functors are created properly from the static constructor
     */
    public function testIdentitiesCanBeConstructed()
    {
        $myIdentity = Identity::identity(7);

        $this->assertInstanceOf(Identity::class, $myIdentity);
    }

    /**
     * Tests that extraction off the functor works for interfacing with PHP land
     */
    public function testFunctorExtract()
    {
        $extract = Functor::using('extract');
        $myIdentity = Identity::identity(7);

        $this->assertEquals($extract($myIdentity), 7);
    }

    /**
     * Tests pure identity construction
     */
    public function testFunctorPure()
    {
        $this->assertEquals(Identity::identity(7), Identity::pure(7));
    }

    /**
     * Tests identity application
     */
    public function testFunctorApply()
    {
        $identityMultiplyBy2 = Identity::identity(function ($value) {
            return $value * 2;
        });

        $mapped = $identityMultiplyBy2->apply(Identity::identity(7));

        $this->assertEquals(Identity::identity(14), $mapped);
    }

    /**
     * Tests bind for identity
     */
    public function testFunctorBind()
    {
        $multiplyBy2 = function ($value) {
            return $value * 2;
        };

        $identity = Identity::identity(7);

        $bound = $identity->bind($multiplyBy2);

        $this->assertEquals(14, $bound);
    }
}
