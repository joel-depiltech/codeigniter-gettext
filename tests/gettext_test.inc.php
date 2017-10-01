<?php
/**
 * This file is include only for test
 */

// Simulate constants defined in CodeIgniter
defined('APPPATH') || define('APPPATH', __DIR__ . '/');

/**
 * Simulate helper functions
 */

// fake log message function
if (!function_exists('log_message')) {
    function log_message($level, $message)
    {
        echo "\n\r" . $level . '|' . $message;
    }
}

// fake get config item function
if (!function_exists('config_item')) {
    function config_item($key)
    {
        $config = array(); // initialize an empty array for avoid IDE error
        require(realpath(__DIR__ . '/../') . '/src/config/gettext.php');
        return $config[$key];
    }
}