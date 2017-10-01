<?php
// @codeCoverageIgnoreStart
defined('BASEPATH') || exit('No direct script access allowed');
// @codeCoverageIgnoreEnd

/**
 * CodeIgniter Gettext Helpers
 *
 * @package        CodeIgniter
 * @subpackage     Helpers
 * @category       Gettext
 * @author         Joël Gaujard <j.gaujard@gmail.com>
 */

if (!function_exists('__')) {
    /**
     * @param string $expression
     * @return string
     */
    function __($expression, $domain = NULL, $category = NULL)
    {
        if (!empty($domain)) {
            (new \Gettext())->changeDomain($domain);

            if (!empty($category))
                return (dcgettext($domain, $expression, $category));

            return (dgettext($domain, $expression));
        }

        return (gettext($expression));
    }
}

if (!function_exists('_e')) {
    /**
     * @param string $expression
     */
    function _e($expression, $domain = NULL)
    {
        echo (__($expression, $domain));
    }
}

if (!function_exists('_n')) {
    /**
     * @param $expression_singular
     * @param $expression_plural
     * @param $number
     * @return string
     */
    function _n($expression_singular, $expression_plural, $number, $domain = NULL, $category = NULL)
    {
        $number = (int) $number;

        if (!empty($domain)) {
            (new \Gettext())->changeDomain($domain);

            if (!empty($category))
                return (dcngettext($domain, $expression_singular, $expression_plural, $number, $category));

            return (dngettext($domain, $expression_singular, $expression_plural, $number));
        }

        return (ngettext($expression_singular, $expression_plural, $number));
    }
}
