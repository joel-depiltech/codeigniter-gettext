<?php
// @codeCoverageIgnoreStart
defined('BASEPATH') || exit('No direct script access allowed');
// @codeCoverageIgnoreEnd

use Gettext\Extractors\Po;
use Gettext\GettextTranslator;
use Gettext\Translations;
use Gettext\Translator;

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
class Gettext extends Translator
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

    public $t;

    /**
     * Initialize Codeigniter PHP framework and get configuration
     *
     * @codeCoverageIgnore
     * @param array $config Override default configuration
     */
    public function __construct(array $config = array())
    {
        log_message('info', 'Gettext Library Class Initialized');

        // Merge $config and config/gettext.php $config
        $config = array_merge(
            array(
                'gettext_catalog_codeset' => config_item('gettext_catalog_codeset'),
                'gettext_locale_dir' => config_item('gettext_locale_dir'),
                'gettext_text_domain' => config_item('gettext_text_domain'),
                'gettext_locale' => config_item('gettext_locale')
            ),
            $config
        );
        $this->_setConfig($config);

        $this->init($config);
    }

    private static function _getPoFile(array $config)
    {
        $path = APPPATH . $config['gettext_locale_dir'] .'/';
        $path .= $config['gettext_locale'];
        $path .= ($config['gettext_catalog_codeset']
            && !preg_match('/'.$config['gettext_catalog_codeset'].'/', $config['gettext_locale']) )
            ? '.' . $config['gettext_catalog_codeset']
            : ''
        ;
        $path .= '/LC_MESSAGES/' . $config['gettext_text_domain'] . '.po';

        return($path);
    }

    private static function _getPhpArrayFile(array $config)
    {
        $path = APPPATH . $config['gettext_locale_dir'] .'/';
        $path .= $config['gettext_text_domain'] . '-';
        $path .= $config['gettext_locale'];
        $path .= ($config['gettext_catalog_codeset']
            && !preg_match('/'.$config['gettext_catalog_codeset'].'/', $config['gettext_locale']) )
            ? '.' . $config['gettext_catalog_codeset']
            : ''
        ;
        $path .= '.php';

        return($path);
    }


    /**
     * Initialize gettext inside Codeigniter PHP framework.
     *
     * @param array $config configuration
     */
    public function init(array $config)
    {
        $translations = new Translations();

        Po::fromFile(self::_getPoFile($config), $translations);

        //$translations = Gettext\Translations::fromPoFile(self::_getPoFile($config));

        $translations->toPhpArrayFile(self::_getPhpArrayFile($config));

        // Create the translator instance
        //$this->t = new Translator();

        $this->defaultDomain($config['gettext_text_domain']);
        $this->loadTranslations($translations);

        // Create the translator instance
        $this->t = new GettextTranslator();

        // Set the language
        $this->t->setLanguage($config['gettext_locale']);

        // Load the domain
        $this->t->loadDomain(
            $config['gettext_text_domain'],
            APPPATH . $config['gettext_locale_dir']
        );

        // Use the global functions as __()
        $this->t->register();

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

    public function changeCategory($category)
    {
        log_message('info', 'Gettext Library Class -> Change category');

        $this->_category = $category;

        $this->_setLocale();
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

        $this->_category = (int) (isset($config['gettext_category'])
            ? $config['gettext_category'] : config_item('gettext_category'));
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
