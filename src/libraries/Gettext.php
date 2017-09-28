<?php
// @codeCoverageIgnoreStart
defined('BASEPATH') || exit('No direct script access allowed');
// @codeCoverageIgnoreEnd

/**
 * Codeigniter PHP framework library class for dealing with gettext.
 *
 * @package     CodeIgniter
 * @subpackage  Libraries
 * @category    Language
 * @author      Joël Gaujard <joel@depiltech.com>
 * @author      Marko Martinović <marko@techytalk.info>
 * @link        https://github.com/joel-depiltech/codeigniter-gettext
 */
class Gettext
{
    /** @var string domain name match with file contains translation */
    private $_textDomain;

    /** @var string character encoding in which the messages are */
    private $_catalogCodeSet;

    /** @var string the path for a domain */
    private $_localeDir;

    /** @var string|array locale or array of locales */
    private $_locale;

    /** @var int constant specifying the category of the functions affected by the locale setting */
    private $_category;

    /**
     * Initialize Codeigniter PHP framework and get configuration
     *
     * @codeCoverageIgnore
     * @param array $config Override default configuration
     */
    public function __construct(array $config = array())
    {
        log_message('info', 'Gettext Library Class Initialized');

        $this->_setConfig($config);

        $this
            ->_bindTextDomainCodeSet()
            ->_bindTextDomain()
            ->_textDomain()
            ->_setLocale()
            ->_putEnv()
            ->_checkLocaleFile()
        ;
    }

    /**
     * Load a domain
     * @param string $domain
     */
    public function changeDomain($domain)
    {
        log_message('info', 'Gettext Library Class -> Change domain');

        $this->_textDomain = $domain;

        $this
            ->_bindTextDomainCodeSet()
            ->_bindTextDomain()
            ->_textDomain()
            ->_checkLocaleFile()
        ;
    }

    /**
     * Merge config as parameter and default config (config/gettext.php file)
     * @param array $config
     */
    private function _setConfig(array $config = array())
    {
        $this->_localeDir = isset($config['gettext_locale_dir'])
            ? $config['gettext_locale_dir'] : config_item('gettext_locale_dir');

        $this->_textDomain = isset($config['gettext_text_domain'])
            ? $config['gettext_text_domain'] : config_item('gettext_text_domain');

        $this->_catalogCodeSet = isset($config['gettext_catalog_codeset'])
            ? $config['gettext_catalog_codeset'] : config_item('gettext_catalog_codeset');

        $this->_locale = isset($config['gettext_locale'])
            ? $config['gettext_locale'] : config_item('gettext_locale');

        $this->_category = LC_ALL;
    }

    /**
     * Gettext catalog codeset
     * @return $this
     */
    private function _bindTextDomainCodeSet()
    {
        $isBindTextDomainCodeSet = bind_textdomain_codeset($this->_textDomain, $this->_catalogCodeSet);

        log_message(
            (is_string($isBindTextDomainCodeSet) ? 'info' : 'error'),
            'Gettext Library -> Bind ' .
            'text domain: ' . $this->_textDomain . ' - ' .
            'with code set: ' . $this->_catalogCodeSet
        );

        return $this;
    }

    /**
     * Path to gettext locales directory relative to APPPATH
     * @return $this
     */
    private function _bindTextDomain()
    {
        $isBindTextDomain = bindtextdomain($this->_textDomain, APPPATH . $this->_localeDir);

        log_message(
            (is_string($isBindTextDomain) ? 'info' : 'error'),
            'Gettext Library -> Bind ' .
            'text domain: ' . $this->_textDomain . ' - ' .
            'with directory: ' . APPPATH . $this->_localeDir
        );

        return $this;
    }

    /**
     * Gettext domain
     * @return $this
     */
    private function _textDomain()
    {
        $isSetTextDomain = textdomain($this->_textDomain);

        log_message(
            (is_string($isSetTextDomain) ? 'info' : 'error'),
            'Gettext Library -> Set text domain: ' . $this->_textDomain
        );

        return $this;
    }

    /**
     * Gettext locale
     * @return $this
     */
    private function _setLocale()
    {
        $isSetLocale = setlocale($this->_category, $this->_locale);

        log_message(
            (is_string($isSetLocale) ? 'info' : 'error'),
            'Gettext Library -> ' .
            'Set locale: ' . (is_array($this->_locale) ? print_r($this->_locale, TRUE) : $this->_locale). ' ' .
            'for category: ' . $this->_category
        );

        // the new current locale, or FALSE if the locale is not implemented on your platform
        $this->_locale = $isSetLocale;

        return $this;
    }

    /**
     * Change environment language for CLI
     * @return $this
     */
    private function _putEnv()
    {
        $isPutEnv = putenv('LANGUAGE=' . $this->_locale);

        log_message(
            ($isPutEnv === TRUE ? 'info' : 'error'),
            'Gettext Library -> Set environment language: ' . $this->_locale
        );

        return $this;
    }

    /**
     * MO file exists for locale
     * @return $this
     */
    private function _checkLocaleFile()
    {
        $file = APPPATH . $this->_localeDir . '/' . $this->_locale . '/LC_MESSAGES/' . $this->_textDomain . '.mo';

        log_message(
            (is_file($file) === TRUE ? 'info' : 'error'),
            'Gettext Library -> Check MO file exists: ' . $file
        );

        return $this;
    }
}

/* End of file Gettext.php */
/* Location: ./libraries/gettext.php */