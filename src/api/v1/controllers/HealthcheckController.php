<?php
namespace API\v1\Controllers;

use HYKY\Api;
use HYKY\Core\ResponseTemplate;
use HYKY\Interfaces\BaseController;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Http\Response;

/**
 * Services : API\v1\Controllers\HealthcheckController
 * ----------------------------------------------------------------------
 * Simple healthcheck route, to see if it's working.
 *
 * @package     API\v1\Controllers
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 */
class HealthcheckController implements BaseController
{
    /**
     * HealthcheckController constructor.
     *
     * @param App $app
     */
    public function __construct(App $app)
    {
        // Set routes
        $app->any("/healthcheck", [$this, "index"]);
    }
    
    /**
     * Base endpoint for this route.
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
        // Set address
        $addr = (isset($_SERVER['SERVER_ADDR']))
            ? $_SERVER['SERVER_ADDR'] : '::1';
    
        // Build response body
        $body = new ResponseTemplate(
            200,
            [
                'info' => [
                    'name'      => Api::API_NAME.' @ '.$addr,
                    'author'    => Api::API_AUTHOR,
                    'version'   => Api::API_VERSION,
                    'license'   => Api::API_LICENSE,
                    'copyright' => Api::API_RIGHTS
                ],
                'message' => 'Welcome to the HYKY Services API'
            ],
            API_DEV_MODE
        );
    
        // Set response
        $return = $response
            ->withHeader('Content-Type', 'application/json')
            ->withJson($body, 200);
        return $return;
    }
}
