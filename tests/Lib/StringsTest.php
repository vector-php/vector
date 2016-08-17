<?php

namespace Vector\Test\Lib;

use Vector\Lib\Strings;

/**
 * Class StringsTest
 * @package Vector\Test\Lib
 */
class StringsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests that lchomp works in an expected case
     */
    public function testLchomp()
    {
        // Base behavior
        $this->assertEquals(
            ' that this is a test, I think',
            Strings::lchomp('I think', 'I think that this is a test, I think')
        );

        // Case sensitive
        $this->assertEquals(
            'I think that this is a test, I think',
            Strings::lchomp('i think', 'I think that this is a test, I think')
        );
    }

    /**
     * Tests that rchomp works in an expected case
     */
    public function testRchomp()
    {
        // Base behavior
        $this->assertEquals(
            'I think that this is a test, ',
            Strings::rchomp('I think', 'I think that this is a test, I think')
        );

        // Case sensitive
        $this->assertEquals(
            'I think that this is a test, I think',
            Strings::rchomp('i think', 'I think that this is a test, I think')
        );
    }

    /**
     * Tests that chomp works in an expected case
     */
    public function testChomp()
    {
        $this->assertEquals(
            ' that this is a test, ',
            Strings::chomp('I think', 'I think that this is a test, I think')
        );
    }

    /**
     * Tests that chomp behaves intuitively, i.e. no character mask
     */
    public function testChompAsTrimReplacement()
    {
        $this->assertEquals('abc', Strings::chomp('bad', 'abc'));
    }

    /**
     * Tests that strings are concatenated like the PHP '.' operation
     */
    public function testStringConcatenation()
    {
        $concat = Strings::using('concat');

        $this->assertEquals('foobar', $concat('bar', 'foo'));
        $this->assertEquals('barbazfoo', $concat('foo', $concat('baz', 'bar')));
    }

    /**
     * Tests that split deferes to PHP explode
     */
    public function testSplitExplodesStrings()
    {
        $split = Strings::using('split');

        $this->assertEquals(['Hello', 'World'], $split(' ', 'Hello World '));
        $this->assertEquals(['foo', 'bar'], $split(' ', 'foo bar'));
        $this->assertEquals(['1', '2', '3'], $split('', '123'));
        $this->assertEquals([], $split(',', ''));
    }

    /**
     * Test that join defers to PHP implode
     */
    public function testJoinImplodesStrings()
    {
        $join = Strings::using('join');

        $this->assertEquals('foo-bar', $join('-', ['foo', 'bar']));
        $this->assertEquals('1234', $join('', ['1', '2', '3', '4']));
        $this->assertEquals('', $join('_', []));
    }

    /**
     * Tests that startsWith handles substrings properly
     */
    public function testStartsWithOnStrings()
    {
        $startsWith = Strings::using('startsWith');

        $this->assertEquals(true, $startsWith('foo', 'foobar'));
        $this->assertEquals(true, $startsWith('1', '12345'));
        $this->assertEquals(false, $startsWith('baz', 'abazfoo'));
    }

    /**
     * Test that toLowercase defers to strtolower
     */
    public function testToLowerCaseOnStrings()
    {
        $toLowercase = Strings::using('toLowercase');

        $this->assertEquals('123', $toLowercase('123'));
        $this->assertEquals('asdf', $toLowercase('ASDf'));
    }
}
