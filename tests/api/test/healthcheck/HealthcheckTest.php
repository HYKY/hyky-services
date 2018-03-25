<?php
namespace API\Test\Healthcheck;

use API\Test\BaseCase;
use HYKY\Api;
use Slim\Http\Environment;
use Slim\Http\Request;

/**
 * Services : API\Test\Healthcheck\HealthcheckTest
 * ----------------------------------------------------------------------
 * Tests for the `/api/v1/healthcheck` endpoint.
 * 
 * @package     API\Test\Healthcheck
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 */
class HealthcheckTest extends BaseCase 
{
    /**
     * Validates the healthcheck endpoint.
     *
     * @return void
     */
    public function testHealthcheck() 
    {
        // Create mock environment
        $env = Environment::mock([
            'REQUEST_METHOD' => 'GET', 
            'REQUEST_URI' => '/api/v1/healthcheck'
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
        
        // Fetch result
        $result = $body['result'];

        // Validate info
        $this->assertTrue(
            (preg_match("/^".Api::API_NAME."/", $result['info']['name']) === 1)
        );
        $this->assertTrue(
            (preg_match("/^".Api::API_AUTHOR."/", $result['info']['author']) === 1)
        );

        // Validate message
        $this->assertSame(
            $result['message'], 
            "Welcome to the HYKY Services API"
        );
    }
}
