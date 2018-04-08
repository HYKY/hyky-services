<?php
namespace API;

use API\v1\Controllers\AuthController;
use API\v1\Controllers\HealthcheckController;
use HYKY\Api;
use HYKY\Core\ResponseTemplate;
use HYKY\Interfaces\BaseController;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Http\Response;

/**
 * Services : API\RouteHandler
 * ----------------------------------------------------------------------
 * Handles application routes and controller assignments.
 *
 * @package     API
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 */
class RouteHandler implements BaseController
{
    /**
     * RouteHandler constructor.
     *
     * @param App $app
     *      `Slim\App` instance from `HYKY\Api`, passed by reference
     */
    public function __construct(&$app)
    {
        // Keep a reference to this instance
        $ctrl = $this;
        
        // Root endpoint
        $app->any("/", [$this, "index"]);
        
        // Set routes
        $app->group("/api", function () use ($app, $ctrl) {
            // API root
            $app->map(
                ["GET", "POST", "OPTIONS", "DELETE", "PUT"],
                "",
                [$ctrl, "root"]
            );
            
            // Api V1 Endpoints
            $app->group("/v1", function () use ($app) {
                // Set V1 application routes
                new HealthcheckController($app);
                new AuthController($app);
            });
            
            // Api V2 Endpoints (testing only)
            $app->group("/v2", function () use ($app, $ctrl) {
                $app->any("/", [$ctrl, "__test"]);
            });
        });
    }
    
    // Route methods
    // ------------------------------------------------------------------
    
    /**
     * Base endpoint.
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return mixed
     */
    public function index(
        Request $request,
        Response $response,
        array $args
    ) {
        // Build response object
        $res = new ResponseTemplate(
            200,
            [
                'message' => 'Hello, Computer!'
            ],
            API_DEV_MODE
        );
        
        $return = $response
            ->withHeader('Content-Type', 'application/json')
            ->withJson($res, 200);
        return $return;
    }
    
    /**
     * API root endpoint.
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return mixed|void
     */
    public function root(
        Request $request,
        Response $response,
        array $args
    ) {
        // Set address
        $addr = (isset($_SERVER['SERVER_ADDR']))
            ? $_SERVER['SERVER_ADDR'] : '::1';
        
        // Build response object
        $res = new ResponseTemplate(
            200,
            [
                'name' => Api::API_NAME.' @ '.$addr,
                'version' => Api::API_VERSION
            ],
            API_DEV_MODE
        );
        
        $return = $response
            ->withHeader('Content-Type', 'application/json')
            ->withJson($res, 200);
        return $return;
    }
    
    /**
     * Test for a not allowed endpoint.
     *
     * @return void
     * @throws \Exception
     */
    public function __test()
    {
        throw new \Exception('Oops! It is a dead end!', 400);
    }
}
