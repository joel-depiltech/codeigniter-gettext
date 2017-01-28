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

    public $t;

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
                'gettext_catalog_codeset' => config_item('gettext_catalog_codeset'),
                'gettext_locale_dir' => config_item('gettext_locale_dir'),
                'gettext_text_domain' => config_item('gettext_text_domain'),
                'gettext_locale' => config_item('gettext_locale')
            ),
            $config
        );

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

        /*
        // Create the translator instance
        $this->t = new GettextTranslator();

        // Set the language
        $this->t->setLanguage($config['gettext_locale']);

        // Load the domain
        $this->t->loadDomain(
            $config['gettext_text_domain'],
            APPPATH . $config['gettext_locale_dir']
        );
        */

        // Use the global functions as __()
        //$this->t->register();
    }
}

/* End of file Gettext.php */
/* Location: ./libraries/config/gettext.php */