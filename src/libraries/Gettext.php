<?php
// @codeCoverageIgnoreStart
defined('BASEPATH') || exit('No direct script access allowed');
// @codeCoverageIgnoreEnd

use Gettext\GettextTranslator;

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
        // Create the translator instance
        $t = new GettextTranslator();

        // Set the language
        $t->setLanguage($config['gettext_locale']);

        // Load the domain
        $t->loadDomain(
            $config['gettext_text_domain'],
            APPPATH . $config['gettext_locale_dir']
        );
    }
}

/* End of file Gettext.php */
/* Location: ./libraries/config/gettext.php */