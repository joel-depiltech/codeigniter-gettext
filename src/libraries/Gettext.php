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
    /**
     * Initialize Codeigniter PHP framework and get configuration
     *
     * @codeCoverageIgnore
     * @param array $config Override default configuration
     */
    public function __construct($config = array())
    {
        log_message('info', 'Gettext Library Class Initialized');

        // Merge $config and config/gettext.php $config
        $config = array_merge(
            array(
                'gettext_locale_dir' => config_item('gettext_locale_dir'),
                'gettext_text_domain' => config_item('gettext_text_domain'),
                'gettext_catalog_codeset' => config_item('gettext_catalog_codeset'),
                'gettext_locale' => config_item('gettext_locale')
            ),
            $config
        );

        self::init($config);
    }

    /**
     * Initialize gettext inside Codeigniter PHP framework.
     *
     * @param array $config configuration
     */
    public static function init(array $config)
    {
        self::bindTextDomainCodeSet($config['gettext_text_domain'], $config['gettext_catalog_codeset']);
        self::bindTextDomain($config['gettext_text_domain'], $config['gettext_locale_dir']);
        self::textDomain($config['gettext_text_domain']);
        $locale = self::setLocale($config['gettext_locale'], LC_ALL);
        self::putEnv($locale);
        self::checkLocaleFile($locale, $config['gettext_locale_dir'], $config['gettext_text_domain']);
    }

    /**
     * Gettext catalog codeset
     * @param string $textDomain
     * @param string $catalogCodeSet
     */
    public static function bindTextDomainCodeSet($textDomain, $catalogCodeSet)
    {
        $isBindTextDomainCodeSet = bind_textdomain_codeset($textDomain, $catalogCodeSet);

        log_message(
            (is_string($isBindTextDomainCodeSet) ? 'info' : 'error'),
            'Gettext Library -> Bind ' .
            'text domain: ' . $textDomain . ' - ' .
            'with code set: ' . $catalogCodeSet
        );
    }

    /**
     * Path to gettext locales directory relative to APPPATH
     * @param string $textDomain
     * @param string $localeDir
     */
    public static function bindTextDomain($textDomain, $localeDir)
    {
        $isBindTextDomain = bindtextdomain($textDomain, APPPATH . $localeDir);

        log_message(
            (is_string($isBindTextDomain) ? 'info' : 'error'),
            'Gettext Library -> Bind ' .
            'text domain: ' . $textDomain . ' - ' .
            'with directory: ' . APPPATH . $localeDir
        );
    }

    /**
     * Gettext domain
     * @param string $textDomain
     */
    public static function textDomain($textDomain)
    {
        $isSetTextDomain = textdomain($textDomain);

        log_message(
            (is_string($isSetTextDomain) ? 'info' : 'error'),
            'Gettext Library -> Set text domain: ' . $textDomain
        );
    }

    /**
     * Gettext locale
     * @param string|array $locale
     * @param int $category
     * @return string|FALSE the new current locale, or FALSE if the locale is not implemented on your platform
     */
    public static function setLocale($locale, $category = LC_ALL)
    {
        $isSetLocale = setlocale($category, $locale);

        log_message(
            (is_string($isSetLocale) ? 'info' : 'error'),
            'Gettext Library -> ' .
            'Set locale: ' . (is_array($locale) ? print_r($locale, TRUE) : $locale). ' ' .
            'for category: ' . $category
        );

        return $isSetLocale;
    }

    /**
     * Change environment language for CLI
     * @param string $locale
     */
    public static function putEnv($locale)
    {
        $isPutEnv = putenv('LANGUAGE=' . $locale);

        log_message(
            ($isPutEnv === TRUE ? 'info' : 'error'),
            'Gettext Library -> Set environment language: ' . $locale
        );
    }

    /**
     * MO file exists for locale
     * @param string $locale
     * @param string $localeDir
     * @param string $textDomain
     */
    public static function checkLocaleFile($locale, $localeDir, $textDomain)
    {
        $file = APPPATH . $localeDir . '/' . $locale . '/LC_MESSAGES/' . $textDomain . '.mo';

        log_message(
            (is_file($file) === TRUE ? 'info' : 'error'),
            'Gettext Library -> Check MO file exists: ' . $file
        );
    }
}

/* End of file Gettext.php */
/* Location: ./libraries/config/gettext.php */