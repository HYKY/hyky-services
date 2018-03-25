<?php
namespace API\Test\Root;

use API\Test\BaseCase;
use HYKY\Api;
use Slim\Http\Environment;
use Slim\Http\Request;

/**
 * Services : API\Test\Root\RootTest
 * ----------------------------------------------------------------------
 * Execute tests on the API's "root" endpoints: `/`, `/api`, `/api/v1`.
 * 
 * @package     API\Test\Root
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 */
class RootTest extends BaseCase 
{
    /**
     * Tests for the "/" path.
     *
     * @return void
     */
    public function testRoot() 
    {
        // Create mock environment
        $env = Environment::mock([
            'REQUEST_METHOD' => 'GET', 
            'REQUEST_URI' => '/'
        ]);

        // Create request object
        $request = Request::createFromEnvironment($env);

        // Set request dependency
        $this->app->getContainer()['request'] = $request;

        // Run the application in silent mode
        $response = $this->app->run(true);

        // Parse JSON body
        $body = json_decode($response->getBody(), true);

        // Assert status code
        $this->assertSame($response->getStatusCode(), 200);

        // Get result
        $result = $body['result'];
        
        // Assert result message
        $this->assertSame($result['message'], "Hello, Computer!");
    }

    /**
     * Tests for the "/api" root endpoint.
     *
     * @return void
     */
    public function testRootApi() 
    {
        // Create mock environment
        $env = Environment::mock([
            'REQUEST_METHOD' => 'GET', 
            'REQUEST_URI' => '/api'
        ]);

        // Create request object
        $request = Request::createFromEnvironment($env);

        // Set request dependency
        $this->app->getContainer()['request'] = $request;

        // Run the application in silent mode
        $response = $this->app->run(true);

        // Parse JSON body
        $body = json_decode($response->getBody(), true);

        // Get result
        $result = $body['result'];

        // Assert status code
        $this->assertSame($response->getStatusCode(), 200);
        
        // Assert API name
        $this->assertTrue(
            (preg_match("/^".Api::API_NAME."/", $result['name']) === 1)
        );
    }

    /**
     * Tests for the "/api/v1" endpoint.
     *
     * @return void
     */
    public function testApiV1() 
    {
        // Create mock environment
        $env = Environment::mock([
            'REQUEST_METHOD' => 'GET', 
            'REQUEST_URI' => '/api/v1'
        ]);

        // Create request object
        $request = Request::createFromEnvironment($env);

        // Set request dependency
        $this->app->getContainer()['request'] = $request;

        // Run the application in silent mode
        $response = $this->app->run(true);

        // Parse JSON body
        $body = json_decode($response->getBody(), true);

        // Get result
        $result = $body['result'];

        // Assert status code
        $this->assertSame($response->getStatusCode(), 401);
        
        // Checks error result
        $this->assertTrue($result['code'] === 401);
        $this->assertSame(
            $result['title'], 
            'Invalid Access Token'
        );
        $this->assertTrue(
            (isset($result['description']) && $result['description'] !== '')
        );
        $this->assertTrue(
            (
                isset($result['data']) 
                && isset($result['data']['message']) 
                && isset($result['data']['token'])
            )
        );
    }
}
