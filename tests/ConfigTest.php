<?php
namespace CodeIgniterGetText\Tests;

class ConfigTest extends \PHPUnit_Framework_TestCase
{

    public function testCatalogCodeSet()
    {
        $config = config_item('gettext_catalog_codeset');
        $this->assertFalse(empty($config));
        $this->assertTrue(is_string($config));
        $this->assertContains($config, mb_list_encodings());
    }

    public function testTextDomain()
    {
        $config = config_item('gettext_text_domain');
        $this->assertFalse(empty($config));
        $this->assertTrue(is_string($config));
    }

    public function testLocaleDir()
    {
        $config = config_item('gettext_locale_dir');
        $this->assertFalse(empty($config));
        $this->assertTrue(is_string($config));
        $this->assertTrue(is_dir(APPPATH . $config));
    }

    public function testLocale()
    {
        $config = config_item('gettext_locale');
        $this->assertFalse(empty($config));
        $this->assertTrue(is_array($config));
    }

    public function testCategory()
    {
        $config = config_item('gettext_category');
        $this->assertFalse(empty($config));
        $this->assertTrue(is_string($config));
    }

}