<?php

namespace Vector\Test\Core;

use Vector\Core\FunctionCapsule;

class FunctionCapsuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test to make sure we can pull functions off the capsule and they'll return closures
     * @covers Vector\Core\FunctionCapsule::using
     */
    public function testUsingFunctions()
    {
        $noArgFunction = Stub\TestFunctions::Using('noArgFunction');

        $functionMap = Stub\TestFunctions::Using('noArgFunction', 'oneArgFunction');

        // Test that singular-loading works
        $this->assertInstanceOf('\\Closure', $noArgFunction);

        // Test that multiple-loading works
        $this->assertInstanceOf('\\Closure', $functionMap[0]);
        $this->assertInstanceOf('\\Closure', $functionMap[1]);
    }

    /**
     * Test to make sure that a function in the function capsule with no arguments is
     * curried properly
     * @covers Vector\Core\FunctionCapsule::curry
     */
    public function testNoArgFunctionIsCurried()
    {
        $noArgFunction = Stub\TestFunctions::Using('noArgFunction');

        // Invoking the function should return true
        $this->assertEquals($noArgFunction(), true);
    }

    /**
     * Test to make sure that one-argument functions are treated like normal functions
     * @covers Vector\Core\FunctionCapsule::curry
     */
    public function testOneArgFunctionIsCurried()
    {
        $oneArgFunction = Stub\TestFunctions::Using('oneArgFunction');

        // Invoking the curried function should be a closure
        $this->assertInstanceOf('\\Closure', $oneArgFunction());

        // Giving an argument to the curried function should return true
        $this->assertEquals($oneArgFunction(true), true);
    }

    /**
     * Test that two-argument functions are curried and partially applicable
     * @covers Vector\Core\FunctionCapsule::curry
     */
    public function testTwoArgFunctionIsCurried()
    {
        $twoArgFunction = Stub\TestFunctions::Using('twoArgFunction');

        $oneArgApplied = $twoArgFunction(true);

        // Invoking the original function should be a closure
        $this->assertInstanceOf('\\Closure', $twoArgFunction());

        // Invoking the applied function should be a closure
        $this->assertInstanceOf('\\Closure', $oneArgApplied());

        // The applied function should be a closure
        $this->assertInstanceOf('\\Closure', $oneArgApplied);

        // The original function, when given 2 args, should return true
        $this->assertEquals($twoArgFunction(true, true), true);

        // The applied function, given its remaining argument, should return true
        $this->assertEquals($oneArgApplied(true), true);
    }

    /**
     * Tests the currying of variadic functions
     * @covers Vector\Core\FunctionCapsule::curry
     */
    public function testVariadicFunctionIsCurried()
    {
        $variadicFunction = Stub\TestFunctions::Using('variadicFunction');

        // Test zero arguments
        $this->assertInstanceOf('\\Closure', $variadicFunction());

        // Test one argument
        $this->assertEquals($variadicFunction('a'), ['a']);

        // Test two arguments
        $this->assertEquals($variadicFunction('a', 'b'), ['a', 'b']);
    }

    /**
     * Tests the currying of functions that mix both normal arguments and variadic
     * functions
     * @covers Vector\Core\FunctionCapsule::curry
     */
    public function testComplicatedVariadicFunctionIsCurried()
    {
        $variadicFunction = Stub\TestFunctions::Using('complexVariadicFunction');

        $oneArgApplied = $variadicFunction(true);

        // Test initial argument
        $this->assertInstanceOf('\\Closure', $oneArgApplied);

        // Test zero arguments
        $this->assertInstanceOf('\\Closure', $oneArgApplied());

        // Test one argument
        $this->assertEquals($oneArgApplied('a'), ['a']);

        // Test two arguments
        $this->assertEquals($oneArgApplied('a', 'b'), ['a', 'b']);
    }

    /**
     * Tests that when a function capsule is set to not curry a specific function
     * that it is not curried
     * @covers Vector\Core\FunctionCapsule::using
     */
    public function testDoesNotCurryFunctionsCorrectly()
    {
        // Given a function with m arguments...
        $nonCurriedFunction = Stub\TestFunctions::Using('nonCurriedFunction');

        // Test that we can't just apply n arguments where n < m
        try {
            $nonCurriedFunction('a');
        } catch (\Exception $e) {
            $this->assertStringStartsWith('Missing argument', $e->getMessage());
        }

        // Test that if we do apply m arguments that we get the right result
        $this->assertEquals($nonCurriedFunction(true, true), true);
    }

    /**
     * Tests that curry works as a regular function off the function capsule for
     * by-hand currying
     * @covers Vector\Core\FunctionCapusle::curry
     */
    public function testCurryWorksStandalone()
    {
        $curry = FunctionCapsule::Using('curry');

        $myInlineLambda = function($a, $b) {
            return $a + $b;
        };

        $myCurriedLambda = $curry($myInlineLambda);

        $this->assertInstanceOf('\\Closure', $myCurriedLambda);
        $this->assertInstanceOf('\\Closure', $myCurriedLambda());
        $this->assertInstanceOf('\\Closure', $myCurriedLambda(1));
        $this->assertEquals(2, $myCurriedLambda(1, 1));
    }
}
