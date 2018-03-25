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

/**
 * Data storage for the project.
 * 
 * This folder stores SQLite databases and some other data. It should not 
 * be used to store uploaded files and images though. These should go into 
 * the `public\` folder for now.
 * 
 * @var string
 */
define('API_DATA_DIR', API_ROOT."\\data");
if (!is_dir(API_DATA_DIR)) mkdir(API_DATA_DIR);

/**
 * Public folder, where the `index.php` file and `.htaccess` file should be 
 * placed.
 * 
 * It's also the place where file uploads and other publicly available files 
 * should be stored.
 * 
 * @var string
 */
define('API_PUBLIC_DIR', API_ROOT."\\public");
if (!is_dir(API_PUBLIC_DIR)) mkdir(API_PUBLIC_DIR);

/**
 * File upload folder. Publicly available files sent through the API 
 * should be kept/stored in this folder for now.
 * 
 * @var string
 */
define('API_UPLOAD_DIR', API_PUBLIC_DIR."\\upload");
if (!is_dir(API_UPLOAD_DIR)) mkdir(API_UPLOAD_DIR);

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

/**
 * Turns HTTPS on and off.
 * 
 * @var bool
 */
define('API_SECURE_MODE', false);
