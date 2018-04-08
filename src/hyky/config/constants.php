<?php
namespace HYKY\Config;

/**
 * Services : HYKY\Config\Constants
 * ----------------------------------------------------------------------
 * Globally used API constants.
 *
 * No need to load'em by hand, since Composer's `autoload.php` does it for us.
 *
 * @package     HYKY\Config
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 */

// API file paths
// ----------------------------------------------------------------------

/**
 * Root directory, usually the repository root.
 *
 * @var string
 */
define('API_ROOT', dirname(dirname(dirname(__DIR__))));

/**
 * Source code directory.
 *
 * @var string
 */
define('API_SOURCE', API_ROOT."\\src");

/**
 * Data storage folder.
 *
 * This folder is used to store XML, JSON and any other text data that's used
 * by the project, but should not be accesible directly by the end user.
 *
 * It also stores any SQLite databases, in case the driver is used instead of
 * MySQL.
 *
 * This folder should not be used for uploaded files and images, as they should
 * go right into the public folder's upload directory.
 *
 * @var string
 */
define('API_DATA_DIR', API_ROOT."\\data");
if (!is_dir(API_DATA_DIR)) mkdir(API_DATA_DIR);

/**
 * Public folder, where the `index.php` and `.htaccess` files should be placed.
 *
 * The upload folder is also created inside this directory.
 *
 * @var string
 */
define('API_PUBLIC_DIR', API_ROOT."\\public");
if (!is_dir(API_PUBLIC_DIR)) mkdir(API_PUBLIC_DIR);

/**
 * File upload directory, publicly available files should be placed inside this
 * folder, as of now.
 *
 * @var string
 */
define('API_UPLOAD_DIR', API_PUBLIC_DIR."\\upload");
if (!is_dir(API_UPLOAD_DIR)) mkdir(API_UPLOAD_DIR);

// API flags
// ----------------------------------------------------------------------

/**
 * Turn debug logs on/off.
 *
 * @var bool
 */
define('API_DEV_LOGS', true);

/**
 * Turns development mode on/off.
 *
 * Use it to set some specific outputs for development mode.
 *
 * @var bool
 */
define('API_DEV_MODE', true);

/**
 * Turns HTTPS mode on/off, specially for authentication.
 *
 * @var bool
 */
define('API_SECURE_MODE', false);
