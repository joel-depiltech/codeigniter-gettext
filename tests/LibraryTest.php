<?php
namespace CodeIgniterGetText\Tests;

class LibraryTest extends \PHPUnit_Framework_TestCase
{

    private function _regex($expression, $successful = TRUE)
    {
        $log = ($successful ? 'info' : 'error') . '\|Gettext Library -> ';
        $regex = '/' . $log . $expression . '/i';
        return ($regex);
    }

    public function testCatalogCodeSetSuccess()
    {
        $this->expectOutputRegex($this->_regex('bind text domain(.*)with code set'));
        $this->_loadLibraryWithDefaultConfig();
    }

    public function testCatalogCodeSetError()
    {
        $this->expectOutputRegex($this->_regex('bind text domain(.*)with code set'));
        $this->_loadLibraryWithOtherConfig();
    }

    public function testLocaleDirSuccess()
    {
        $this->expectOutputRegex($this->_regex('bind text domain(.*)with directory', FALSE));
        $this->_loadLibraryWithDefaultConfig();
    }

    public function testLocaleDirError()
    {
        $this->expectOutputRegex($this->_regex('bind text domain(.*)with directory'));
        $this->_loadLibraryWithOtherConfig();
    }

    public function testTextDomainSuccess()
    {
        $this->expectOutputRegex($this->_regex('set text domain'));
        $this->_loadLibraryWithDefaultConfig();
    }

    public function testTextDomainError()
    {
        $this->expectOutputRegex($this->_regex('set text domain'));
        $this->_loadLibraryWithOtherConfig();
    }

    public function testLocaleSuccess()
    {
        $this->expectOutputRegex($this->_regex('set locale'));
        $this->_loadLibraryWithDefaultConfig();
    }

    public function testLocaleError()
    {
        $this->expectOutputRegex($this->_regex('set locale'));
        $this->_loadLibraryWithOtherConfig();
    }

    public function testEnvironmentLanguageSuccess()
    {
        $this->expectOutputRegex($this->_regex('set environment language'));
        $this->_loadLibraryWithDefaultConfig();
    }

    public function testEnvironmentLanguageError()
    {
        $this->expectOutputRegex($this->_regex('set environment language'));
        $this->_loadLibraryWithOtherConfig();
    }

    public function testFileExistsSuccess()
    {
        $this->expectOutputRegex($this->_regex('check MO file exists', FALSE));
        $this->_loadLibraryWithDefaultConfig();
    }

    public function testFileExistsError()
    {
        $this->expectOutputRegex($this->_regex('check MO file exists'));
        $this->_loadLibraryWithOtherConfig();
    }

    private function _loadLibraryWithDefaultConfig()
    {
        $config = array();
        // Load default config array
        require(realpath(__DIR__ . '/../') . '/src/config/gettext.php');
        \Gettext::init($config);
    }

    private function _loadLibraryWithOtherConfig()
    {
        $config = array(
            'gettext_locale_dir' => 'testTranslations',
            'gettext_text_domain' => 'my-domain',
            'gettext_catalog_codeset' => 'UTF-8',
            'gettext_locale' => 'fr_FR'
        );
        \Gettext::init($config);
    }

}
