<?php
use HYKY\Api;

// Require Composer autoload
require_once("../vendor/autoload.php");

/**
 * Services : Index
 * ----------------------------------------------------------------------
 * Requires the autoload file, fires the API, runs the API, period.
 * 
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 */
(new Api())->getApp()->run();
// Yes, that's everything...you want more?
