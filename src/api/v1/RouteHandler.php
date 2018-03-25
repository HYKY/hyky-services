<?php
namespace API\v1;

use API\v1\Controllers\HealthcheckController;
use HYKY\Api;
use HYKY\Core\BaseController;
use HYKY\Core\ResponseTemplate;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response;

/**
 * Services : API\v1\RouteHandler
 * ----------------------------------------------------------------------
 * Handles application routes and controller assignment.
 * 
 * @package     API\v1
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 */
class RouteHandler implements BaseController 
{
    /**
     * RouteHandler constructor
     *
     * @param Api $app 
     *      HYKY\Api instance reference
     */
    public function __construct(&$app) 
    {
        // Keep a reference to this instance
        $ctrl = $this;

        // Root access
        $app->any("/", [$this, "index"]);

        // Set all routes
        $app->group("/api", function () use ($app, $ctrl) {
            // API root
            $app->map(
                ["GET", "POST", "OPTIONS", "DELETE", "PIT"], 
                "", 
                [$ctrl, 'apiRoot']
            );

            // API v1
            $app->group("/v1", function () use ($app, $ctrl) {
                // Set all routes below
                new HealthcheckController($app);
            });
        });
    }

    /**
     * Base method, equals to the index, or base path, for the route.
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
            true
        );

        $return = $response
            ->withHeader('Content-Type', 'application/json')
            ->withJson($res, 200);
        return $return;
    }

    /**
     * Handles request to the API's root address.
     *
     * @param Request $request 
     * @param Response $response
     * @param array $args
     * @return mixed
     */
    public function apiRoot(
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
            true
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
