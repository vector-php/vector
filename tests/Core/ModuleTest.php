<?php

namespace Vector\Test\Core;

use Vector\Core\Module;
use Vector\Core\Exception\FunctionNotFoundException;

class ModuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test to make sure we can pull functions off the capsule and they'll return closures
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
     * Test that the module caches function resolutions
     */
    public function testModuleCaching()
    {
        // Loading the function should add it to the cache
        $notAPureFunction = Stub\TestFunctions::using('notAPureFunction');

        $cache = Stub\TestFunctions::getFulfillmentCache()['Vector\Test\Core\Stub\TestFunctions'];

        $this->assertArrayHasKey('__notAPureFunction', $cache);
    }

    /**
     * Test alternative function calling scheme
     */
    public function testAlternativeFunctionPattern()
    {
        $this->assertInstanceOf('\\Closure', Stub\TestFunctions::oneArgFunction());
    }

    /**
     * Tests that memoization works on the module
     */
    public function testMemoization()
    {
        $memoizedFunction = Stub\TestFunctions::using('memoizedFunction');

        // On the first run we expect side effects
        ob_start();
        $this->assertEquals($memoizedFunction(1, 2, 3), 6);
        $sideEffects = ob_get_clean();

        $this->assertEquals($sideEffects, "I'm a side effect.");

        // But on the second run we don't
        ob_start();
        $this->assertEquals($memoizedFunction(1, 2, 3), 6);
        $sideEffects = ob_get_clean();

        $this->assertEquals($sideEffects, "");
    }

    /**
     * Test that caching on the Module core works by returning exact duplicates of the functions you request
     */
    public function testCachedFunctions()
    {
        $noArgFunctionA = Stub\TestFunctions::Using('noArgFunction');
        $noArgFunctionB = Stub\TestFunctions::Using('noArgFunction');

        $this->assertEquals($noArgFunctionA, $noArgFunctionB);
        $this->assertEquals($noArgFunctionA(), $noArgFunctionB());
    }

    /**
     * Test to make sure that a function in the function capsule with no arguments is
     * curried properly
     */
    public function testNoArgFunctionIsCurried()
    {
        $noArgFunction = Stub\TestFunctions::Using('noArgFunction');

        // Invoking the function should return true
        $this->assertEquals($noArgFunction(), true);
    }

    /**
     * Test to make sure that one-argument functions are treated like normal functions
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
     */
    public function testDoesNotCurryFunctionsCorrectly()
    {
        // Given a function with m arguments...
        $nonCurriedFunction = Stub\TestFunctions::Using('nonCurriedFunction');

        // Test that we can't just apply n arguments where n < m
        try {
            $nonCurriedFunction('a');
        } catch (\Exception $e) {
            $this->assertRegExp('/missing argument 2|expects exactly 2|exactly 2 expected/i', $e->getMessage());
        } catch (\Throwable $e) {
            $this->assertRegExp('/missing argument 2|expects exactly 2|exactly 2 expected/i', $e->getMessage());
        }

        // Test that if we do apply m arguments that we get the right result
        $this->assertEquals($nonCurriedFunction(true, true), true);
    }

    /**
     * Tests that curry works as a regular function off the function capsule for
     * by-hand currying
     */
    public function testCurryWorksStandalone()
    {
        $curry = Module::Using('curry');

        $myInlineLambda = function($a, $b) {
            return $a + $b;
        };

        $myCurriedLambda = $curry($myInlineLambda);
        $partiallyApplied = $myCurriedLambda(1);

        // A curried function should be a closure
        $this->assertInstanceOf('\\Closure', $myCurriedLambda);

        // Invoking a curried function should be a closure
        $this->assertInstanceOf('\\Closure', $myCurriedLambda());

        // Passing the first argument should return a closure
        $this->assertInstanceOf('\\Closure', $partiallyApplied);

        // Passing the arguments all at once should be a result
        $this->assertEquals(3, $partiallyApplied(2));

        // Passing all the remaining arguments should be a result
        $this->assertEquals(2, $myCurriedLambda(1, 1));
    }

    public function testThatUsingReturnsExceptionForNonExistantFunction()
    {
        $this->expectException(FunctionNotFoundException::class);

        Stub\TestFunctions::using('someFunctionThatDoesNotExist');
    }

    public function testCurryingNativeFunctions()
    {
        $implode = Module::curry('implode');
        $implodeCommas = $implode(',');

        $this->assertEquals('a,b,c', $implodeCommas(['a', 'b', 'c']));
    }
}
