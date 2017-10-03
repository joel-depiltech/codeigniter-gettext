<?php
// @codeCoverageIgnoreStart
defined('BASEPATH') || exit('No direct script access allowed');
// @codeCoverageIgnoreEnd
/**
 * CodeIgniter Gettext Helpers
 *
 * @package    CodeIgniter
 * @subpackage Helpers
 * @category   Gettext
 * @author     Joël Gaujard <j.gaujard@gmail.com>
 */

if (!function_exists('__')) {
   /**
    * Search translation to simple expression
    *
    * @param  string $expression
    * @param  string $domain
    * @param  string $category
    * @return string
   */
    function __($expression, $domain=null, $category=null)
    {
        if (!empty($domain)) {
            (new \Gettext())->changeDomain($domain);

            if (!empty($category)) {
                $category = is_int($category) ? $category : constant($category);
                return (dcgettext($domain, $expression, $category));
            }

            return (dgettext($domain, $expression));
        }

        return (gettext($expression));

    }
}

if (!function_exists('_e')) {
    /**
     * Display a simple expression
     *
     * @param string $expression
     * @param string $domain
     * @param string $category
     */
    function _e($expression, $domain=null, $category=null)
    {
        echo (__($expression, $domain, $category));

    }
}

if (!function_exists('_n')) {
    /**
     * Search translation to expression and its plural
     *
     * @param  string $expression_singular
     * @param  string $expression_plural
     * @param  int    $number
     * @param  string $domain
     * @param  string $category
     * @return string
     */
    function _n(
        $expression_singular,
        $expression_plural,
        $number,
        $domain=null,
        $category=null
    ) {
        $number = (int) $number;

        if (!empty($domain)) {
            (new \Gettext())->changeDomain($domain);

            if (!empty($category)) {
                $category = is_int($category) ? $category : constant($category);
                return (dcngettext(
                    $domain,
                    $expression_singular,
                    $expression_plural,
                    $number,
                    $category
                ));
            }

            return (dngettext(
                $domain,
                $expression_singular,
                $expression_plural,
                $number
            ));
        }

        return (ngettext($expression_singular, $expression_plural, $number));
    }
}

/* End of file gettext_helper.php */
/* Location: ./application/helpers/gettext_helper.php */