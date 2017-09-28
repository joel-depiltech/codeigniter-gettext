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
    function __($expression, $domain = NULL)
    {
        if (!empty($domain)) {
            (new \Gettext())->changeDomain($domain);
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
    function _n($expression_singular, $expression_plural, $number, $domain = NULL)
    {
        $number = (int) $number;

        if (!empty($domain)) {
            (new \Gettext())->changeDomain($domain);
            return (dngettext($domain, $expression_singular, $expression_plural, $number));
        }

        return (ngettext($expression_singular, $expression_plural, $number));
    }
}