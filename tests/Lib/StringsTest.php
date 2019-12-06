<?php

namespace Vector\Test\Lib;

use PHPUnit\Framework\TestCase;
use Vector\Lib\Strings;

class StringsTest extends TestCase
{
    /** @test */
    function lchomp()
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

    /** @test */
    function rchomp()
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

    /** @test */
    function chomp()
    {
        $this->assertEquals(
            ' that this is a test, ',
            Strings::chomp('I think', 'I think that this is a test, I think')
        );
    }

    /** @test */
    function chomp_as_trim_replacement_no_char_mask()
    {
        $this->assertEquals('abc', Strings::chomp('bad', 'abc'));
    }

    /** @test */
    function concat()
    {
        $concat = Strings::using('concat');

        $this->assertEquals('foobar', $concat('bar', 'foo'));
        $this->assertEquals('barbazfoo', $concat('foo', $concat('baz', 'bar')));
    }

    /** @test */
    function split()
    {
        $split = Strings::using('split');

        $this->assertEquals(['Hello', 'World'], $split(' ', 'Hello World '));
        $this->assertEquals(['foo', 'bar'], $split(' ', 'foo bar'));
        $this->assertEquals(['1', '2', '3'], $split('', '123'));
        $this->assertEquals([], $split(',', ''));
    }

    /** @test */
    function join()
    {
        $join = Strings::using('join');

        $this->assertEquals('foo-bar', $join('-', ['foo', 'bar']));
        $this->assertEquals('1234', $join('', ['1', '2', '3', '4']));
        $this->assertEquals('', $join('_', []));
    }

    /** @test */
    function starts_with()
    {
        $startsWith = Strings::using('startsWith');

        $this->assertEquals(true, $startsWith('foo', 'foobar'));
        $this->assertEquals(true, $startsWith('1', '12345'));
        $this->assertEquals(false, $startsWith('baz', 'abazfoo'));
    }

    /** @test */
    function to_lowercase()
    {
        $toLowercase = Strings::using('toLowercase');

        $this->assertEquals('123', $toLowercase('123'));
        $this->assertEquals('asdf', $toLowercase('ASDf'));
    }

    /** @test */
    function to_uppercase()
    {
        $this->assertEquals('123', Strings::toUppercase('123'));
        $this->assertEquals('ASDF', Strings::toUppercase('asdf'));
    }

    /** @test */
    function trim()
    {
        $this->assertEquals('asdf', Strings::trim(' asdf '));
    }

    /** @test */
    function replace()
    {
        $this->assertEquals(Strings::replace('test', 'passes', 'this test'), 'this passes');
    }
}
