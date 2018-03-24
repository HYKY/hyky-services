<?php
namespace HYKY\Config;

/**
 * Services : HYKY\Config\Constants
 * ----------------------------------------------------------------------
 * Globally used API constants.
 * 
 * No need to load'em by hand, since Composer's `autoload.php` does that 
 * job for us beforehand! :)
 * 
 * @package     HYKY\Config
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 */

// API paths
// ----------------------------------------------------------------------

/**
 * Root directory.
 * 
 * @var string
 */
define('API_ROOT', dirname(dirname(dirname(__DIR__))));

/**
 * Source directory.
 * 
 * @var string
 */
define('API_SOURCE', API_ROOT."\\src");

// API flags
// ----------------------------------------------------------------------

/**
 * Turns debug logs on/off.
 * 
 * @var bool
 */
define('API_DEV_LOGS', true);

/**
 * Turns development mode on/off.
 * 
 * @var bool
 */
define('API_DEV_MODE', true);
