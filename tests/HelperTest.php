<?php
namespace CodeIgniterGetText\Tests;

class HelperTest extends \PHPUnit_Framework_TestCase
{
    const EXPRESSION = 'Let me test this expression';
    const EXPRESSION_PLURAL = 'Let me test this plural expression';
    const DOMAIN = 'domain';
    const CATEGORY = LC_MESSAGES;

    public function testDoubleUnderscore()
    {
        $this->assertTrue(function_exists('__'), "__ function does not exists.");
        $this->assertEquals(self::EXPRESSION, __(self::EXPRESSION));
        $this->assertEquals(self::EXPRESSION, __(self::EXPRESSION, self::DOMAIN));
        $this->assertEquals(self::EXPRESSION, __(self::EXPRESSION, self::DOMAIN, self::CATEGORY));
    }

    public function testUnderscoreE()
    {
        $this->assertTrue(function_exists('_e'), "_e function does not exists.");
        $this->expectOutputString(self::EXPRESSION);
        _e(self::EXPRESSION);
    }

    public function testUnderscoreE_WithDomain()
    {
        $this->expectOutputString(self::EXPRESSION, self::DOMAIN);
        _e(self::EXPRESSION);
    }

    public function testUnderscoreE_WithDomainAndCategory()
    {
        $this->expectOutputString(self::EXPRESSION, self::DOMAIN, self::CATEGORY);
        _e(self::EXPRESSION);
    }

    public function testUnderscoreN()
    {
        $this->assertTrue(function_exists('_n'), "_n function does not exists.");

        $this->assertEquals(
            self::EXPRESSION,
            _n(self::EXPRESSION, self::EXPRESSION_PLURAL, 1)
        );
        $this->assertEquals(
            self::EXPRESSION_PLURAL,
            _n(self::EXPRESSION, self::EXPRESSION_PLURAL, 2)
        );

        $this->assertEquals(
            self::EXPRESSION,
            _n(self::EXPRESSION, self::EXPRESSION_PLURAL, 1, self::DOMAIN)
        );
        $this->assertEquals(
            self::EXPRESSION_PLURAL,
            _n(self::EXPRESSION, self::EXPRESSION_PLURAL, 2, self::DOMAIN)
        );

        $this->assertEquals(
            self::EXPRESSION,
            _n(self::EXPRESSION, self::EXPRESSION_PLURAL, 1, self::DOMAIN, self::CATEGORY)
        );
        $this->assertEquals(
            self::EXPRESSION_PLURAL,
            _n(self::EXPRESSION, self::EXPRESSION_PLURAL, 2, self::DOMAIN, self::CATEGORY)
        );
    }

}