<?php
namespace API\v1;

/**
 * Services : API\v1\Routesi
 * ----------------------------------------------------------------------
 * Loads API paths for the `JwtAuthentication` middleware from the data in 
 * `routes.json` file, located in the `\data` folder.
 * 
 * @package     API\v1
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 */
class Routes 
{
    /**
     * API paths to consider when validating authentication.
     *
     * @var array
     */
    protected $path;

    /**
     * API paths to passthrough authentication.
     *
     * @var array
     */
    protected $passthrough;

    /**
     * Routes constructor.
     */
    public function __construct() 
    {
        // File
        $file = API_DATA_DIR.'\\routes.json';

        // Get contents and set JSON
        $data = json_decode(
            file_get_contents($file), 
            true
        );

        // Set values
        $this->path = $data['path'];
        $this->passthrough = $data['passthrough'];
    }

    /**
     * Returns path data.
     *
     * @return array
     */
    public function getPath(): array 
    {
        return $this->path;
    }

    /**
     * Returns passthrough path data.
     *
     * @return array
     */
    public function getPassthrough(): array 
    {
        return $this->passthrough;
    }
}
