<?php
namespace HYKY\Interfaces;

use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response;

/**
 * Services : HYKY\Core\Interfaces\BaseController
 * ----------------------------------------------------------------------
 * Base route controller interface, implements the minimum required for the
 * route to work, since ALL routes require an `index`.
 *
 * @package     HYKY\Core\Interfaces
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 */
interface BaseController
{
    /**
     * Base methods, stands for the index/base path for the current route.
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
