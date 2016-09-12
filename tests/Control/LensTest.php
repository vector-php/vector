<?php

namespace Vector\Test\Control;

use Vector\Control\Lens;

use Vector\Lib\Lambda;

/**
 * Class LensTest
 * @package Vector\Test\Control
 */
class LensTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test that lenses can be created at all
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
     * Test that indexLens throws on non-existent index
     * @expectedException \Vector\Core\Exception\IndexOutOfBoundsException
     */
    public function testIndexLensThrows()
    {
        list($view, $indexLens) = Lens::using('viewL', 'indexLens');

        $arr = [1, 2, 3];
        $lens = $indexLens(4);

        $view($lens, $arr);
    }

    /**
     * Test that propLens throws on undefined property
     * @expectedException \Vector\Core\Exception\UndefinedPropertyException
     */
    public function testPropLensThrows()
    {
        list($view, $propLens) = Lens::using('viewL', 'propLens');

        $obj = new \stdClass();
        $lens = $propLens('value');

        $view($lens, $obj);
    }

    /**
     * Test that indexLens is null on non-existent index
     */
    public function testIndexSafeLensIsNull()
    {
        list($view, $indexLens) = Lens::using('viewL', 'indexLensSafe');

        $arr = [1, 2, 3];
        $lens = $indexLens(4);

        self::assertEquals(null, $view($lens, $arr));
    }

    /**
     * Test that pathLens can traverse arrays
     */
    public function testPathLens()
    {
        list($view, $pathLens) = Lens::using('viewL', 'pathLens');

        $arr = [1, 2, 'nested' => [
            'value' => 5
        ]];

        $lens = $pathLens(['nested', 'value']);

        self::assertEquals(5, $view($lens, $arr));
    }

    /**
     * Test that pathLens can traverse objects
     */
    public function testPathPropLens()
    {
        list($view, $pathPropLens) = Lens::using('viewL', 'pathPropLens');

        $obj = new \stdClass();
        $second = new \stdClass();
        $second->value = 'works';
        $obj->first = $second;

        $lens = $pathPropLens(['first', 'value']);

        self::assertEquals('works', $view($lens, $obj));
    }

    /**
     * @expectedException \Vector\Core\Exception\IndexOutOfBoundsException
     */
    public function testPathLensNullsOnBadPath()
    {
        list($view, $pathLens) = Lens::using('viewL', 'pathLens');

        $arr = [1, 2, 'nested' => [
            'value' => 5
        ]];

        $lens = $pathLens(['bad', 'path']);

        $view($lens, $arr);
    }

    /**
     * Test that you can view through indexLens
     */
    public function testViewThroughArrayLens()
    {
        list($view, $indexLens) = Lens::using('viewL', 'indexLens');

        $arr = [1, 2, 3];
        $lens = $indexLens(1);

        $this->assertEquals(2, $view($lens, $arr));
    }

    /**
     * Test that you can view through propLens
     */
    public function testViewThroughObjectLens()
    {
        list($view, $propLens) = Lens::using('viewL', 'propLens');

        $obj = new \stdClass();
        $obj->a = 'foo';

        $lens = $propLens('a');

        $this->assertEquals('foo', $view($lens, $obj));
    }

    /**
     * Test that you can set through indexLens. Also test that it results
     * in immutability.
     */
    public function testSetThroughArrayLens()
    {
        list($set, $indexLens) = Lens::using('setL', 'indexLens');

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
     */
    public function testSetThroughObjectLens()
    {
        list($set, $propLens) = Lens::using('setL', 'propLens');

        $obj = new \stdClass();
        $obj->a = 'foo';

        $objOriginal = new \stdClass();
        $objOriginal->a = 'foo';

        $expected = new \stdClass();
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
     */
    public function testOverArrayLens()
    {
        list($over, $indexLens) = Lens::using('overL', 'indexLens');

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
     */
    public function testOverObjectLens()
    {
        list($over, $propLens) = Lens::using('overL', 'propLens');

        $obj = new \stdClass();
        $obj->a = 'foo';

        $expected = new \stdClass();
        $expected->a = 'foobar';

        $lens = $propLens('a');

        $testFn = function ($a) {
            return $a . 'bar';
        };

        // Test that over works
        // Set uses over, so testing that set does not mutate implies that over
        // does not mutate
        $this->assertEquals($expected, $over($lens, $testFn, $obj));
    }

    /**
     * Test lens composition - covers all lens types
     */
    public function testLensComposition()
    {
        list($view, $indexLens, $propLens) = Lens::using('viewL', 'indexLens', 'propLens');
        $compose = Lambda::using('compose');

        $complexLens = $compose($propLens('a'), $indexLens(0));

        $obj = new \stdClass();
        $obj->a = [1, 2, 3];

        // Test viewing with complex lenses
        // Lenses compose into lenses, and all lens functions are tested by other
        // tests
        $this->assertEquals(1, $view($complexLens, $obj));
    }
}
