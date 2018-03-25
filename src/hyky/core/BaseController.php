<?php
namespace HYKY\Core;

use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response;

/**
 * Services : HYKY\Core\BaseController
 * ----------------------------------------------------------------------
 * Base route controller, implements an index method so all routes have 
 * at least one method to return data (or something else).
 * 
 * @package     HYKY\Core
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 */
interface BaseController 
{
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
    );
}
