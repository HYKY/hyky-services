<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use HYKY\Api;

/**
 * Services : CLI Config (Doctrine)
 * ----------------------------------------------------------------------
 * Used by Doctrine's Entity Builder.
 * 
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 */
require_once 'vendor/autoload.php';

// Fire application and get container
$container = (new Api())->getContainer();

// Get entity manager
$em = $container->get('em');

// Return helper set
return ConsoleRunner::createHelperSet($em);
