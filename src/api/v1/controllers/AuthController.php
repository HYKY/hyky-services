<?php
namespace API\v1\Controllers;

use API\Models\Entity\Users\UserToken;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Firebase\JWT\JWT;
use HYKY\Core\ResponseTemplate;
use HYKY\Core\Salt;
use HYKY\Interfaces\BaseController;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Container;
use Slim\Http\Response;

/**
 * Services : API\v1\Controllers\AuthController
 * ----------------------------------------------------------------------
 * Handles authentication and JWT validation.
 *
 * @package     API\v1\Controllers
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 */
class AuthController implements BaseController
{
    /**
     * `Slim\Container` handle.
     *
     * @var Container
     */
    protected $container;
    
    /**
     * AuthController constructor.
     *
     * @param App $app
     */
    public function __construct(App &$app)
    {
        // Set reference
        $this->container = $app->getContainer();
    
        // Keep a reference to this instance
        $ctrl = $this;
        
        // Define routes
        $app->group('/auth', function () use ($app, $ctrl) {
            // Authentication handler
            // API root
            $app->map(
                ["POST"],
                "",
                [$ctrl, "index"]
            );
            
            // Token validation
            $app->post("/validate", [$ctrl, 'validate']);
        });
    }
    
    /**
     * Base endpoint.
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return mixed
     * @throws \Exception
     */
    public function index(
        Request $request,
        Response $response,
        array $args
    ) {
        // Get credentials
        $credentials = $this->userLoginCredentials($request);
        
        // No username or e-mail
        if (!isset($credentials['username']) && !isset($credentials['email'])) {
            throw new \Exception('No username/e-mail provided.', 401);
        }
        
        // Get entityManager
        /** @var EntityManager $em */
        $em = $this->container->get('em');
        
        // Get user
        $user = $em->getRepository("API\Models\Entity\Users\User");
        
        // Search arguments
        $args = [];
        if (isset($credentials['email'])) {
            $args['email'] = $credentials['email'];
        }
        if (isset($credentials['username'])) {
            $args['username'] = $credentials['username'];
        }
        
        // Search for user
        $user = $user->findOneBy($args);
        
        // Checks if login is valid
        if ($user === null || !$user) {
            throw new \Exception(
                'Invalid username/e-mail address.',
                401
            );
        }
        
        // Check password
        $pass = explode("§", $user->getPassword());
        
        // Invalid password
        if (
            !$credentials['password']
            || !\password_verify($credentials['password'], $pass[0])
            || $pass[1] !== Salt::get()
        ) {
            throw new \Exception(
                'Invalid password.',
                401
            );
        }
        
        // Invalidate previous tokens
        $this->invalidateAllTokens($user->getId());
        
        // Set token values
        $token = [
            'payload' => $user->getTokenPayload(),
            'created' => time(),
            'expires' => time() + (60 * 60 * 24 * 7)
        ];
        
        // Sign token
        $jwt = JWT::encode($token, Salt::get());
        
        // Save the token into the database
        $save = (new UserToken())
            ->setExpiresAt($token['expires'])
            ->setIsValid(true)
            ->setToken($jwt)
            ->setUser($user);
        // Save token
        $em->persist($save);
        $em->flush();
        
        // Return response
        $return = new ResponseTemplate(
            200,
            [
                "token" => $jwt
            ],
            API_DEV_MODE
        );
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withJson($return, 200);
    }
    
    /**
     * Endpoint used for token validation.
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return mixed
     * @throws \Exception
     */
    public function validate(
        Request $request,
        Response $response,
        array $args
    ) {
        // Fetch token from request
        $token = ($request->getHeader('Authorization')[0]);
        
        // If token is empty
        if ($token === null || $token === false || $token === '') {
            throw new \Exception('No token provided.', 401);
        }
        
        // Decode the token
        try {
            $jwt = JWT::decode($token, Salt::get(), ['HS256']);
        } catch (\Exception $e) {
            throw new \Exception('Invalid user token provided.', 401);
        }
        
        // Check expiration
        // TODO: Implement expiration date checker
        
        // Return the payload data, if valid
        $return = new ResponseTemplate(
            200,
            (array) $jwt,
            API_DEV_MODE
        );
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withJson($return);
    }
    
    // Private methods
    // ------------------------------------------------------------------
    
    /**
     * Invalidates all previous tokens for the user ID provided.
     *
     * @param int $user_id
     * @return void
     */
    protected function invalidateAllTokens(int $user_id)
    {
        // Get entityManager and queryBuilder
        /** @var EntityManager $em */
        $em = $this->container->get('em');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder();
        
        // Set all tokens as invalid
        $qb->update('API\Models\Entity\Users\UserToken', 't')
            ->set('t.is_valid', 'false')
            ->where("t.user = {$user_id}")
            ->andWhere('t.is_valid = true')
            ->getQuery()
            ->execute();
    }
    
    /**
     * Searches the request for login credentials and returns them as an
     * associative array.
     *
     * @param Request $request
     * @return array
     */
    protected function userLoginCredentials(Request $request): array
    {
        // Get params
        $params = ($request->getMethod() === 'GET')
            ? $request->getQueryParams() : $request->getParsedBody();
        
        // Array to hold user data
        $user = [];
        
        // Get username or e-mail address
        if (isset($params['email'])) {
            // Extract e-mail address
            $user['email'] = trim($params['email']);
        } elseif (isset($params['user']) || isset($params['username'])) {
            // Extract value
            $curr = (isset($params['user']))
                ? trim($params['user']) : trim($params['username']);
            
            // Checks if the param is an e-mail address
            if (filter_var($curr, FILTER_VALIDATE_EMAIL)) {
                $user['email'] = $curr;
            } else {
                $user['username'] = $curr;
            }
        }
        
        // Only fetch password if username or e-mail is set
        if (isset($user['username']) || isset($user['email'])) {
            if (isset($params['pass']) || isset($params['password'])) {
                $user['password'] = (isset($params['pass']))
                    ? trim($params['pass']) : trim($params['password']);
            }
        }
        
        return $user;
    }
}