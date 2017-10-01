<?php
namespace CodeIgniterGetText\Tests;

class LibraryTest extends \PHPUnit_Framework_TestCase
{

    private function _loadLibraryWithDefaultConfig()
    {
        $config = array();
        // Load default config array
        require(realpath(__DIR__ . '/../') . '/src/config/gettext.php');
        new \Gettext($config);
    }

    private function _loadLibraryWithOtherConfig()
    {
        $config = array(
            'gettext_locale_dir' => 'translations',
            'gettext_text_domain' => 'my-domain',
            'gettext_catalog_codeset' => 'UTF-8',
            'gettext_locale' => array('en_GB.UTF-8', 'en_GB'),
            'gettext_category' => 'LC_MESSAGES'
        );
        new \Gettext($config);
    }

    private function _regex($expression, $successful = TRUE)
    {
        $log = ($successful ? 'info' : 'error') . '\|Gettext Library -> ';
        $regex = '/' . $log . $expression . '/i';
        return ($regex);
    }

    public function testCatalogCodeSetDefaultConfig()
    {
        $this->expectOutputRegex($this->_regex('bind text domain(.*)with code set'));
        $this->_loadLibraryWithDefaultConfig();
    }

    public function testCatalogCodeSetOtherConfig()
    {
        $this->expectOutputRegex($this->_regex('bind text domain(.*)with code set'));
        $this->_loadLibraryWithOtherConfig();
    }

    public function testLocaleDirDefaultConfig()
    {
        $this->expectOutputRegex($this->_regex('bind text domain(.*)with directory'));
        $this->_loadLibraryWithDefaultConfig();
    }

    public function testLocaleDirOtherConfig()
    {
        $this->expectOutputRegex($this->_regex('bind text domain(.*)with directory'));
        $this->_loadLibraryWithOtherConfig();
    }

    public function testTextDomainDefaultConfig()
    {
        $this->expectOutputRegex($this->_regex('set text domain'));
        $this->_loadLibraryWithDefaultConfig();
    }

    public function testTextDomainOtherConfig()
    {
        $this->expectOutputRegex($this->_regex('set text domain'));
        $this->_loadLibraryWithOtherConfig();
    }

    public function testLocaleDefaultConfig()
    {
        $this->expectOutputRegex($this->_regex('set locale'));
        $this->_loadLibraryWithDefaultConfig();
    }

    public function testLocaleOtherConfig()
    {
        $this->expectOutputRegex($this->_regex('set locale'));
        $this->_loadLibraryWithOtherConfig();
    }

    public function testEnvironmentLanguageDefaultConfig()
    {
        $this->expectOutputRegex($this->_regex('set environment language'));
        $this->_loadLibraryWithDefaultConfig();
    }

    public function testEnvironmentLanguageOtherConfig()
    {
        $this->expectOutputRegex($this->_regex('set environment language'));
        $this->_loadLibraryWithOtherConfig();
    }

    public function testFileExistsDefaultConfig()
    {
        $this->expectOutputRegex($this->_regex('check MO file exists', FALSE));
        $this->_loadLibraryWithDefaultConfig();
    }

    public function testFileExistsOtherConfig()
    {
        $this->expectOutputRegex($this->_regex('check MO file exists'));
        $this->_loadLibraryWithOtherConfig();
    }

}
