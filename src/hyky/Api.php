<?php
namespace HYKY;

// Set libraries
use Dotenv\Dotenv;
use Monolog\Logger;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Container;
use Slim\Http\Response;

/**
 * Services : HYKY\Api
 * ----------------------------------------------------------------------
 * Application handler, fires a runnable/returnable `Slim\App` instance.
 * 
 * We could do this without a class, but we're aiming to use this instance 
 * for testing. :)
 * 
 * @package     HYKY
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 */
class Api 
{
    // Constants
    // ------------------------------------------------------------------

    /**
     * API name.
     * 
     * @var string 
     */
    const API_NAME = "HYKY : Services";

    /**
     * API author name.
     * 
     * @var string 
     */
    const API_AUTHOR = "HYKY Team <we@hyky.games>";

    /**
     * API version.
     * 
     * @var string 
     */
    const API_VERSION = "0.0.1";

    /**
     * API license.
     * 
     * @var string 
     */
    const API_LICENSE = "MIT";

    /**
     * API credits.
     * 
     * @var string 
     */
    const API_RIGHTS = "©2018 HYKY Team";

    // Private properties
    // ------------------------------------------------------------------

    /**
     * Slim application handle.
     *
     * @var App
     */
    protected $app;

    /**
     * Slim container handle.
     * 
     * Used to inject dependencies and execute other stuff.
     *
     * @var Container
     */
    protected $container;

    // Constructor
    // ------------------------------------------------------------------

    /**
     * Api constructor.
     */
    public function __construct() 
    {
        // Load environment variables from the `.env` file in `API_ROOT`
    }

    // Public methods
    // ------------------------------------------------------------------

    /**
     * Returns the Slim application instance.
     *
     * @return App
     */
    public function getApp(): App 
    {
        return $this->app;
    }

    /**
     * Returns the Container instance.
     *
     * @return Container
     */
    public function getContainer(): Container 
    {
        return $this->container;
    }

    // Protected methods
    // ------------------------------------------------------------------
}
