<?php
namespace API\Test;

use HYKY\Api;
use PHPUnit\Framework\TestCase;
use Slim\App;

/**
 * Services : API\Test\BaseCas
 * ----------------------------------------------------------------------
 * Base test case, all tests extend from this one.
 * 
 * Boots the API application instance.
 * 
 * @package     API\Test
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 */
class BaseCase extends TestCase 
{
    /**
     * `Slim\App` handle.
     *
     * @var App
     */
    protected $app;

    /**
     * Fires the main API application.
     *
     * @return void
     */
    public function setUp() 
    {
        // Set app
        $this->app = (new Api())->getApp();
    }
}
