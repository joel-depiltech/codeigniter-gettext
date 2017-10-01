<?php
// @codeCoverageIgnoreStart
defined('BASEPATH') || exit('No direct script access allowed');
// @codeCoverageIgnoreEnd

// Gettext domain
/**
 * Gettext catalog codeset
 * Specify the character encoding in which the messages from the DOMAIN message catalog will be returned
 */
$config['gettext_catalog_codeset'] = 'UTF-8';

/**
 * Gettext domain
 * DOMAIN message catalog
 */
$config['gettext_text_domain'] = 'default';

/**
 * Directory path to gettext locale directory relative to APPPATH
 */
$config['gettext_locale_dir'] = 'language/locales';

/**
 * Gettext locale
 * If locale is NULL or the empty string "", the locale names will be set from the values of
 * environment variables with the same names as the above categories, or from "LANG".
 * If locale is "0", the locale setting is not affected, only the current setting is returned.
 * If locale is an array or followed by additional parameters then each array element
 * or parameter is tried to be set as new locale until success.
 * This is useful if a locale is known under different names on different systems
 * or for providing a fallback for a possibly not available locale.
 */
$config['gettext_locale'] = Array("en_US.UTF-8", "en_US@euro", "en_US", "english", "eng", "en");

/**
 * Gettext Category is a named constant specifying the category of the functions affected by the locale setting:
 * LC_ALL for all of the below
 * LC_COLLATE for string comparison, see strcoll()
 * LC_CTYPE for character classification and conversion, for example strtoupper()
 * LC_MONETARY for localeconv()
 * LC_NUMERIC for decimal separator (See also localeconv())
 * LC_TIME for date and time formatting with strftime()
 * LC_MESSAGES for system responses (available if PHP was compiled with libintl)
 */
$config['gettext_category'] = LC_MESSAGES;

/* End of file gettext.php */
/* Location: ./application/config/gettext.php */
