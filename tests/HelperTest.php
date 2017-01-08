<?php
namespace CodeIgniterGetText\Tests;

class HelperTest extends \PHPUnit_Framework_TestCase
{
    const EXPRESSION = "Let me test this expression";
    const EXPRESSION_PLURAL = "Let me test this plural expression";

    public function testDoubleUnderscore_Exits()
    {
        $this->assertTrue(function_exists('__'), "__ function do not exists.");
    }

    public function testDoubleUnderscore()
    {
        $this->assertEquals(self::EXPRESSION, __(self::EXPRESSION));
    }

    public function testUnderscoreE_Exits()
    {
        $this->assertTrue(function_exists('_e'), "_e function do not exists.");
    }

    public function testUnderscroreE()
    {
        $this->expectOutputRegex('/' . self::EXPRESSION . '/');
        _e(self::EXPRESSION);
    }

    public function testUnderscoreN_Exits()
    {
        $this->assertTrue(function_exists('_n'), "_e function do not exists.");
    }

    public function testUnderscroreN_Singular()
    {
        $this->assertEquals(
            self::EXPRESSION,
            _n(self::EXPRESSION, self::EXPRESSION_PLURAL, 1)
        );
    }

    public function testUnderscroreN_Plural()
    {
        $this->assertEquals(
            self::EXPRESSION_PLURAL,
            _n(self::EXPRESSION, self::EXPRESSION_PLURAL, 2)
        );
    }

}