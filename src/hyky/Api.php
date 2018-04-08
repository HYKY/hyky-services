<?php
namespace HYKY;

use API\RouteHandler;
use API\v1\Routes;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Dotenv\Dotenv;
use HYKY\Core\ClientInformation;
use HYKY\Core\ResponseError;
use HYKY\Core\ResponseTemplate;
use HYKY\Core\Salt;
use HYKY\Core\Utilities;
use Monolog\Handler\FingersCrossedHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr7Middlewares\Middleware\TrailingSlash;
use Slim\App;
use Slim\Container;
use Slim\Http\Response;
use Slim\Middleware\JwtAuthentication;
use Tuupola\Middleware\Cors;

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
    const API_AUTHOR = "HYKY team <we@hyky.games>";
    
    /**
     * API license type.
     *
     * @var string
     */
    const API_LICENSE = "MIT";
    
    /**
     * API version.
     *
     * @var string
     */
    const API_VERSION = "0.0.1";
    
    /**
     * API credits/copyright.
     *
     * @var string
     */
    const API_RIGHTS = "(c) 2018 HYKY team";
    
    // Properties
    // ------------------------------------------------------------------
    
    /**
     * `Slim\App` instance handler.
     *
     * @var App
     */
    protected $app;
    
    /**
     * `Slim\Container` instance handler.
     *
     * Used to inject dependencies into the `Slim\App` instance.
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
        // Environment variables and config
        // --------------------------------------------------------------
        
        // Load the `.env` file's variables
        (new Dotenv(API_ROOT))->load();
        
        // Set container config
        $config = [
            'settings' => [
                'displayErrorDetails' => API_DEV_MODE,
                'debug' => API_DEV_MODE
            ]
        ];
        
        // Set container and inject dependencies
        try {
            $this->container = new Container($config);
            $this->dependencies();
        } catch (\Exception $e) {
            $this->errorHandleOnStart($e, 'Dependency container error.');
        }
        
        // Start application
        // --------------------------------------------------------------
        
        // Fire application with container
        $this->app = new App($this->container);
        
        // Fire `RouteHandler`
        new RouteHandler($this->app);
        
        // Set middleware
        // --------------------------------------------------------------
        
        // Add trailing slash middleware (so we won't have problems later)
        $this->app->add(new TrailingSlash(false));
        
        // Add authentication middleware
        $this->authentication();
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
    
    /**
     * Handles authentication and JWT validation.
     *
     * @return void
     */
    protected function authentication()
    {
        // Container
        /** @var Container $container */
        $container = $this->app->getContainer();
        
        // Load application routes
        $routes = new Routes();
        
        // Set CORS middleware (important for ALL requests!)
        $this->app->add(
            new Cors([
                "origin" => ["*"],
                "methods" => ["GET", "POST", "PUT", "PATCH", "OPTIONS ", "DELETE"],
                "headers.allow" => ['Authorization', 'Content-Type', 'X-Token'],
                "headers.expose" => [],
                "credentials" => false,
                "cache" => 0,
                "error" => null
            ])
        );
        
        // Add JWT authentication
        $this->app->add(
            new JwtAuthentication([
                // So we can use it with HTTP
                "secure" => API_SECURE_MODE,
                // Security salt
                "secret" => Salt::get(),
                // API path to check for authentication
                "path" => $routes->getPaths(),
                // API paths to passthrough
                "passthrough" => $routes->getPassthroughs(),
                "regexp" => "/(.*)/",
                "header" => "X-Token",
                "realm" => "Protected",
                // Passthrough OPTIONS (not used)
                #"rules" => ["OPTIONS"],
                // Success callback
                "callback" => function (
                    Request $request,
                    Response $response,
                    $args
                ) use ($container) {
                    // Get entity manager
                    /** @var EntityManager $em */
                    $em = $container->get('em');
                    
                    // Get token payload header
                    $token = ($request->getHeader('Authorization')[0]);
                    
                    // Find it in the DB
                    $token = $em
                        ->getRepository("API\Models\Entity\Users\UserToken")
                        ->findOneBy(['token' => $token]);
                    
                    // If token is invalid, trigger error
                    if (
                        null === $token
                        || false === $token
                        || false === $token->getIsValid()
                    ){
                        return false;
                    }
                    
                    // IMPORTANT: Further validation for permission might
                    // be needed on the endpoints! Use the array below!
                    
                    // Set decoded jwt token
                    $container['jwt'] = $args['decoded'];
                    return true;
                },
                // Error callback
                "error" => function (
                    Request $request,
                    Response $response,
                    $args
                ) use ($container) {
                    // Generate error
                    $err = new ResponseError(
                        401,
                        'Invalid Access Token',
                        'The token provided is invalid and/or has expired.',
                        $args
                    );
                    
                    // Response object
                    $res = new ResponseTemplate(
                        401,
                        $err,
                        true
                    );
    
                    // Get user address
                    $addr = (isset($_SERVER['REMOTE_ADDR']))
                        ? $_SERVER['REMOTE_ADDR'] : '::1';
                    
                    // Log
                    /** @var $logger Logger */
                    $logger = $container['logger'];
                    $logger->info(
                        'User @ '.$addr.' reached a 401',
                        (new ClientInformation())->toArray()
                    );
                    $logger->info(
                        Utilities::httpStatusName(401)
                        .': Expired/invalid token.'
                    );
                    $logger->info(
                        'Request body: '.$request->getBody()
                    );
                    
                    // Return data
                    return $response
                        ->withHeader('Content-Type', 'application/json')
                        ->withJson($res, 401);
                }
            ])
        );
    }
    
    /**
     * Injects dependencies into the application's container.
     *
     * @return void
     * @throws \Exception
     */
    protected function dependencies()
    {
        // Get container reference
        $container = &$this->container;
        
        // EntityManager config
        $entity_config = Setup::createAnnotationMetadataConfiguration(
            [
                API_SOURCE."\\api\\models\\entity\\"
            ],
            API_DEV_MODE
        );
        
        // EntityManager database config
        try {
            // Fetch driver from env
            $dbdriver = getenv('DATABASE_DRIVER');
            
            // No driver declared? Halt!
            if ($dbdriver === false) {
                throw new \Exception('Database driver failure.', 500);
            }
            
            switch ($dbdriver) {
                case 'pdo_mysql':
                case 'pdo_pgsql':
                    $connection = [
                        'driver' => getenv('DATABASE_DRIVER'),
                        'host' => getenv('DATABASE_HOSTNAME'),
                        'dbname' => getenv('DATABASE_DATABASE'),
                        'user' => getenv('DATABASE_USERNAME'),
                        'password' => getenv('DATABASE_PASSWORD')
                    ];
                    break;
                case 'pdo_sqlite':
                    // SQLite uses `path` instead of `host`
                    $connection = [
                        'driver' => getenv('DATABASE_DRIVER'),
                        'path' => API_DATA_DIR."\\".getenv('DATABASE_HOSTNAME')
                    ];
                    break;
                default:
                    // Not a valid driver
                    throw new \Exception('Invalid database driver.', 500);
                    break;
            }
        } catch (\Exception $e) {
            $this->errorHandleOnStart($e, 'Database initialization error.');
        }
        
        // EntityManager
        // --------------------------------------------------------------
        
        // Checks for connection or throws error
        if (!isset($connection)) {
            throw new \Exception(
                'No connection for the EntityManager.',
                500
            );
        }
    
        $em = EntityManager::create($connection, $entity_config);
        $container['em'] = $em;
        
        // Entity sanitizer (cleans some accents)
        // --------------------------------------------------------------
        $container['sanitizer'] = function () {
            return function ($string) {
                $string = (!mb_check_encoding($string, "UTF-8"))
                    ? utf8_encode($string) : $string;
                // Convert special chars into HTML entities
                $string = htmlentities( $string, ENT_COMPAT, "UTF-8" );
                // Regex flag for entities
                $flag = "uml|acute|grave|circ|tilde|cedil|ring|slash|u";
                return preg_replace( "/&([A-Za-z])({$flag});/", "$1", $string );
            };
        };
        
        // Logger
        // --------------------------------------------------------------
        $container['logger'] = function () {
            $logger = new Logger('hyky-logger');
            $logfile = API_ROOT."\\logs\\hyky-logs.log";
            $stream = new StreamHandler($logfile, Logger::DEBUG);
            $fingersCrossed = new FingersCrossedHandler(
                $stream,
                Logger::INFO
            );
            $logger->pushHandler($fingersCrossed);
            return $logger;
        };
        
        // Custom exception/error handler
        // --------------------------------------------------------------
        $container['errorHandler'] = function ($container) {
            return function (
                Request $request,
                Response $response,
                \Exception $exception
            ) use ($container) {
                // Set status code
                $code = ($exception->getCode()) ? $exception->getCode() : 500;
                if ($code < 100) $code = 500;
                
                // Set error body
                $err = new ResponseError(
                    $code,
                    Utilities::httpStatusName($code),
                    $exception->getMessage(),
                    json_encode($exception->getTrace())
                );
                
                // Set response
                $res = new ResponseTemplate(
                    $code,
                    $err,
                    API_DEV_MODE
                );
                
                // Get user address
                $addr = (isset($_SERVER['REMOTE_ADDR']))
                    ? $_SERVER['REMOTE_ADDR'] : '::1';
                
                // Log
                /** @var $logger Logger */
                $logger = $container['logger'];
                $logger->info(
                    'User @ '.$addr.' reached a '.$code,
                    (new ClientInformation())->toArray()
                );
                $logger->info(
                    Utilities::httpStatusName($code)
                    .': '.$exception->getMessage()
                );
                $logger->info(
                    'Request body: '.$request->getBody()
                );
                
                return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus($code)
                    ->withJson($res, $code);
            };
        };
        
        // Custom 404 error handler
        // --------------------------------------------------------------
        $container['notFoundHandler'] = function ($container) {
            return function (
                Request $request,
                Response $response
            ) use ($container) {
                // Set error body
                $err = new ResponseError(
                    404,
                    'Not Found',
                    'The requested resource wasn\'t found or is inaccessible.'
                );
                
                // Set response
                $res = new ResponseTemplate(
                    404,
                    $err,
                    API_DEV_MODE
                );
                
                // Log
                /** @var $logger Logger */
                $logger = $container['logger'];
                $logger->info(
                    'User @ '.$_SERVER['REMOTE_ADDR'].' reached a 404',
                    (new ClientInformation())->toArray()
                );
                $logger->info(
                    'Request body: '.$request->getBody()
                );
                
                return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(404)
                    ->withJson($res, 404);
            };
        };
        
        // Custom 405 error handler
        // --------------------------------------------------------------
        $container['notAllowedHandler'] = function ($container) {
            return function (
                Request $request,
                Response $response,
                array $methods
            ) use ($container) {
                // Implode allowed
                $methods = implode(', ', $methods);
                
                // Set error body
                $err = new ResponseError(
                    405,
                    'Not Allowed',
                    'Method not allowed. Must be one of: '.$methods.'.'
                );
                
                // Set response
                $res = new ResponseTemplate(
                    405,
                    $err,
                    API_DEV_MODE
                );
                
                // Log
                /** @var $logger Logger */
                $logger = $container['logger'];
                $logger->info(
                    'User @ '.$_SERVER['REMOTE_ADDR'].' reached a 405',
                    (new ClientInformation())->toArray()
                );
                $logger->info(
                    'Request body: '.$request->getBody()
                );
                
                return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withHeader('Allow', $methods)
                    ->withHeader('Access-Control-Allow-Methods', $methods)
                    ->withStatus(405)
                    ->withJson($res, 405);
            };
        };
    }
    
    /**
     * Prints an error response before `Slim\App` is intiialized.
     *
     * Only used during bootstrap and database initialization, since we
     * don't have the response object before it's fired.
     *
     * @param \Exception $e
     *      Exception handle
     * @param string $title
     *      Error title
     * @return void
     */
    protected function errorHandleOnStart(\Exception $e, string $title)
    {
        // Error response
        $err = new ResponseError(
            $e->getCode(),
            $title,
            $e->getMessage(),
            $e->getTrace()
        );
        
        // Set header and print JSON error
        header('Content-Type', 'application/json');
        echo \json_encode(
            new ResponseTemplate(
                $e->getCode(),
                $err,
                API_DEV_MODE
            )
        );
    }
}
