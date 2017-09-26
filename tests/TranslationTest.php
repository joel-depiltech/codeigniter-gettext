<?php
namespace CodeIgniterGetText\Tests;

class TranslationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @before
     */
    public function testFrenchLocale()
    {
        $config = array(
            'gettext_locale_dir' => 'testTranslations',
            'gettext_text_domain' => 'my-domain',
            'gettext_catalog_codeset' => 'UTF-8',
            'gettext_locale' => 'fr_FR'
        );

        // only for avoid output when launch test
        $this->expectOutputRegex('//');

        \Gettext::init($config);
    }

    public function testDoubleUnderscore()
    {
        $this->assertEquals('Une expression en Français', __('A expression in English'));
    }

    public function testUnderscoreE()
    {
        $this->expectOutputRegex('/' . preg_quote('Une expression en Français') . '$/');
        _e('A expression in English');
    }

    public function testUnderscoreN()
    {
        $this->assertEquals(
            'Une expression au singulier', _n('A singular expression', 'A plural expression', 1)
        );
        $this->assertEquals(
            'Une expression au pluriel', _n('A singular expression', 'A plural expression', 2)
        );
    }

}