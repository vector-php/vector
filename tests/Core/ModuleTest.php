<?php

namespace Vector\Test\Core;

use PHPUnit\Framework\TestCase;
use Vector\Core\Module;
use Vector\Core\Exception\FunctionNotFoundException;
use Vector\Test\Core\Stub\TestFunctions;

class ModuleTest extends TestCase
{
    /** @test */
    function can_load_function_via_using_functions()
    {
        $noArgFunction = TestFunctions::using('noArgFunction');

        $functionMap = TestFunctions::using('noArgFunction', 'oneArgFunction');

        // Test that singular-loading works
        $this->assertInstanceOf('\\Closure', $noArgFunction);

        // Test that multiple-loading works
        $this->assertInstanceOf('\\Closure', $functionMap[0]);
        $this->assertInstanceOf('\\Closure', $functionMap[1]);
    }

    /** @test */
    function module_caching()
    {
        // Loading the function should add it to the cache
        TestFunctions::using('notAPureFunction');

        $cache = TestFunctions::getFulfillmentCache()[
            'Vector\Test\Core\Stub\TestFunctions'
        ];

        $this->assertArrayHasKey('__notAPureFunction', $cache);
    }

    /** @test */
    function test_alternative_function_pattern()
    {
        $this->assertInstanceOf('\\Closure', TestFunctions::oneArgFunction());
    }

    /** @test */
    function test_memoization()
    {
        $memoizedFunction = TestFunctions::using('memoizedFunction');

        // On the first run we expect side effects
        ob_start();
        $this->assertEquals($memoizedFunction(1, 2, 3), 6);
        $sideEffects = ob_get_clean();

        $this->assertEquals($sideEffects, "I'm a side effect.");

        // But on the second run we don't
        ob_start();
        $this->assertEquals($memoizedFunction(1, 2, 3), 6);
        $sideEffects = ob_get_clean();

        $this->assertEquals($sideEffects, '');
    }

    /** @test */
    function test_cached_functions()
    {
        $noArgFunctionA = TestFunctions::using('noArgFunction');
        $noArgFunctionB = TestFunctions::using('noArgFunction');

        $this->assertEquals($noArgFunctionA, $noArgFunctionB);
        $this->assertEquals($noArgFunctionA(), $noArgFunctionB());
    }

    /** @test */
    function no_arg_function_is_curried()
    {
        $noArgFunction = TestFunctions::using('noArgFunction');

        // Invoking the function should return true
        $this->assertEquals($noArgFunction(), true);
    }

    /** @test */
    function one_arg_function_is_curried()
    {
        $oneArgFunction = TestFunctions::using('oneArgFunction');

        // Invoking the curried function should be a closure
        $this->assertInstanceOf('\\Closure', $oneArgFunction());

        // Giving an argument to the curried function should return true
        $this->assertEquals($oneArgFunction(true), true);
    }

    /** @test */
    function two_arg_function_is_curried()
    {
        $twoArgFunction = TestFunctions::using('twoArgFunction');

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

    /** @test */
    function test_curried_argument_unpacking()
    {
        $twoArgFunction = TestFunctions::twoArgFunction();

        $this->assertInstanceOf('\\Closure', $twoArgFunction(...[true]));
        $this->assertEquals($twoArgFunction(...[true, true]), true);
    }

    /** @test */
    function test_variadic_function_is_curried()
    {
        $variadicFunction = TestFunctions::using('variadicFunction');

        // Test zero arguments
        $this->assertInstanceOf('\\Closure', $variadicFunction());

        // Test one argument
        $this->assertEquals($variadicFunction('a'), ['a']);

        // Test two arguments
        $this->assertEquals($variadicFunction('a', 'b'), ['a', 'b']);
    }

    /** @test */
    function test_complicated_variadic_function_is_curried()
    {
        $variadicFunction = TestFunctions::using('complexVariadicFunction');

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

    /** @test */
    function test_can_not_curry_functions()
    {
        // Given a function with m arguments...
        $nonCurriedFunction = TestFunctions::using('nonCurriedFunction');

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

    /** @test */
    function curry_works_standalone()
    {
        $curry = Module::using('curry');

        $myInlineLambda = function ($a, $b) {
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

    /** @test */
    function using_returns_exception_for_non_existent_function()
    {
        $this->expectException(FunctionNotFoundException::class);

        TestFunctions::using('someFunctionThatDoesNotExist');
    }

    /** @test */
    function currying_native_functions()
    {
        $implode = Module::curry('implode');
        $implodeCommas = $implode(',');

        $this->assertEquals('a,b,c', $implodeCommas(['a', 'b', 'c']));
    }
}
