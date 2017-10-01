<?php
namespace CodeIgniterGetText\Tests;

class TranslationTest extends \PHPUnit_Framework_TestCase
{
    const OVERRIDE_DOMAIN = 'override-domain';

    /**
     * @before
     */
    public function testOtherLocale()
    {
        $config = array(
            'gettext_locale_dir' => 'translations',
            'gettext_text_domain' => 'my-domain',
            'gettext_catalog_codeset' => 'UTF-8',
            'gettext_locale' => array('en_GB.UTF-8', 'en_GB')
        );

        // only for avoid output when launch test
        $this->expectOutputRegex('//');

        new \Gettext($config);
    }

    public function testDoubleUnderscore()
    {
        $this->assertEquals('Same expression in British English', __('A expression in English'));
    }

    public function testUnderscoreE()
    {
        $this->expectOutputRegex('/' . preg_quote('Same expression in British English') . '$/');
        _e('A expression in English');
    }

    public function testUnderscoreN()
    {
        $this->assertEquals(
            'Same singular expression in British English', _n('A singular expression', 'A plural expression', 1)
        );
        $this->assertEquals(
            'Same plural expression in British English', _n('A singular expression', 'A plural expression', 2)
        );
    }

    public function testUnderscoreEOverrideDomain()
    {
        $this->expectOutputRegex('/' . preg_quote('A expression overridden') . '$/');
        _e('A expression in English', self::OVERRIDE_DOMAIN);
    }

    public function testDoubleUnderscoreOverrideDomain()
    {
        $this->assertEquals('A expression overridden', __('A expression in English', self::OVERRIDE_DOMAIN));
    }

    public function testUnderscoreNOverrideDomain()
    {
        $this->assertEquals(
            'A singular expression overridden',
            _n('A singular expression', 'A plural expression', 1, self::OVERRIDE_DOMAIN)
        );
        $this->assertEquals(
            'A plural expression overridden',
            _n('A singular expression', 'A plural expression', 2, self::OVERRIDE_DOMAIN)
        );
    }


    public function testDoubleUnderscoreOverrideDomainAndCategory()
    {
        $this->assertEquals(
            'A expression overridden',
            __('A expression in English', self::OVERRIDE_DOMAIN, 'LC_MESSAGES')
        );
        $this->assertEquals(
            'A expression in English',
            __('A expression in English', self::OVERRIDE_DOMAIN, 'LC_TIME')
        );
    }

    public function testUnderscoreEOverrideDomainAndCategory()
    {
        $this->expectOutputRegex('/' . preg_quote('A expression overridden') . '$/');
        _e('A expression in English', self::OVERRIDE_DOMAIN, 'LC_MESSAGES');
    }

    public function testUnderscoreEOverrideDomainAndCategoryError()
    {
        $this->expectOutputRegex('/' . preg_quote('A expression in English') . '$/');
        _e('A expression in English', self::OVERRIDE_DOMAIN, 'LC_TIME');
    }

    public function testUnderscoreNOverrideDomainAndCategory()
    {
        $this->assertEquals(
            'A singular expression overridden',
            _n('A singular expression', 'A plural expression', 1, self::OVERRIDE_DOMAIN, 'LC_MESSAGES')
        );
        $this->assertEquals(
            'A plural expression overridden',
            _n('A singular expression', 'A plural expression', 2, self::OVERRIDE_DOMAIN, 'LC_MESSAGES')
        );

        $this->assertEquals(
            'A singular expression',
            _n('A singular expression', 'A plural expression', 1, self::OVERRIDE_DOMAIN, 'LC_TIME')
        );
        $this->assertEquals(
            'A plural expression',
            _n('A singular expression', 'A plural expression', 2, self::OVERRIDE_DOMAIN, 'LC_TIME')
        );
    }

}
