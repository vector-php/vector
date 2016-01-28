<?php

namespace Vector\Test\Control;

use Vector\Control\Lens;

use Vector\Lib\Lambda;

class LensTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Lenses use Identity functor constructors - test those here
     * @covers Vector\Control\Lens::identity
     */
    public function testConstituentIdentity()
    {
        $identity = Lens::using('identity');

        $this->assertInstanceOf('\\Vector\\Data\\Identity', $identity(true));
    }

    /**
     * Lenses use Constant functor constructors - test those here
     * @covers Vector\Control\Lens::constant
     */
    public function testConstituentConstant()
    {
        $constant = Lens::using('constant');

        $this->assertInstanceOf('\\Vector\\Data\\Constant', $constant(true));
    }

    /**
     * Test that lenses can be created at all
     * @covers Vector\Control\Lens::indexLens
     * @covers Vector\Control\Lens::propLens
     */
    public function testLensesCanBeCreated()
    {
        list($indexLens, $propLens) = Lens::Using('indexLens', 'propLens');

        $testIndex = $indexLens(0);
        $testProp  = $propLens('a');

        $this->assertInstanceOf('\\Closure', $testIndex);
        $this->assertInstanceOf('\\Closure', $testProp);
    }

    /**
     * Test that you can view through indexLens
     * @covers Vector\Control\Lens::view
     */
    public function testViewThroughArrayLens()
    {
        list($view, $indexLens) = Lens::Using('view', 'indexLens');

        $arr = [1, 2, 3];
        $lens = $indexLens(1);

        $this->assertEquals(2, $view($lens, $arr));
    }

    /**
     * Test that you can view through propLens
     * @covers Vector\Control\Lens::view
     */
    public function testViewThroughObjectLens()
    {
        list($view, $propLens) = Lens::Using('view', 'propLens');

        $obj = new \StdClass();
        $obj->a = 'foo';

        $lens = $propLens('a');

        $this->assertEquals('foo', $view($lens, $obj));
    }

    /**
     * Test that you can set through indexLens. Also test that it results
     * in immutability.
     * @covers Vector\Control\Lens::set
     */
    public function testSetThroughArrayLens()
    {
        list($set, $indexLens) = Lens::Using('set', 'indexLens');

        $arr = [1, 2, 3];
        $lens = $indexLens(1);

        // Test that set works
        $this->assertEquals([1, 4, 3], $set($lens, 4, $arr));

        // Test that set does not mutate data
        $this->assertEquals([1, 2, 3], $arr);
    }

    /**
     * Test that you can set through objectLens. Also test that it results
     * in immutability.
     * @covers Vector\Control\Lens::set
     */
    public function testSetThroughObjectLens()
    {
        list($set, $propLens) = Lens::Using('set', 'propLens');

        $obj = new \StdClass();
        $obj->a = 'foo';

        $objOriginal = new \StdClass();
        $objOriginal->a = 'foo';

        $expected = new \StdClass();
        $expected->a = 'bar';

        $lens = $propLens('a');

        // Test that set works
        $this->assertEquals($expected, $set($lens, 'bar', $obj));

        // Test that set does not mutate data
        $this->assertEquals($objOriginal, $obj);
    }

    /**
     * Test that map over indexLenses. Also test that it results
     * in immutability.
     * @covers Vector\Control\Lens::over
     */
    public function testOverArrayLens()
    {
        list($over, $indexLens) = Lens::Using('over', 'indexLens');

        $arr = [1, 2, 3];
        $lens = $indexLens(1);

        $testFn = function($a) {
            return $a + 7;
        };

        // Test that over works
        // Set uses over, so testing that set does not mutate implies that over
        // does not mutate
        $this->assertEquals([1, 9, 3], $over($lens, $testFn, $arr));
    }

    /**
     * Test that map over propLenses. Also test that it results in immutability.
     * @covers Vector\Control\Lens::over
     */
    public function testOverObjectLens()
    {
        list($over, $propLens) = Lens::Using('over', 'propLens');

        $obj = new \StdClass();
        $obj->a = 'foo';

        $expected = new \StdClass();
        $expected->a = 'foobar';

        $lens = $propLens('a');

        $testFn = function($a) {
            return $a . 'bar';
        };

        // Test that over works
        // Set uses over, so testing that set does not mutate implies that over
        // does not mutate
        $this->assertEquals($expected, $over($lens, $testFn, $obj));
    }

    /**
     * Test lens composition - covers all lens types
     * @covers Vector\Control\Lens::indexLens
     * @covers Vector\Control\Lens::propLens
     */
    public function testLensComposition()
    {
        list($view, $indexLens, $propLens) = Lens::Using('view', 'indexLens', 'propLens');
        $compose = Lambda::Using('compose');

        $complexLens = $compose($propLens('a'), $indexLens(0));

        $obj = new \StdClass();
        $obj->a = [1, 2, 3];

        // Test viewing with complex lenses
        // Lenses compose into lenses, and all lens functions are tested by other
        // tests
        $this->assertEquals(1, $view($complexLens, $obj));
    }
}