<?php
namespace API\v1;

/**
 * Services : API\v1\Routes
 * ----------------------------------------------------------------------
 * Loads API routes to be used by the `JwtAuthentication` middleware directly
 * from the data inside `routes.json` in the application `\data` folder.
 *
 * @package     API\v1
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 */
class Routes
{
    /**
     * API paths where validation is mandatory.
     *
     * @var array
     */
    protected $paths;
    
    /**
     * API paths to passthrough token validation.
     *
     * They're mostly the public endpoints.
     *
     * @var array
     */
    protected $passthroughs;
    
    /**
     * Routes constructor.
     */
    public function __construct()
    {
        // File
        $file = API_DATA_DIR."\\routes.v1.json";
        
        // Get contents and decode
        $data = json_decode(
            file_get_contents($file),
            true
        );
        
        // Set values
        $this->paths = $data['paths'];
        $this->passthroughs = $data['passthroughs'];
    }
    
    /**
     * Returns path data.
     *
     * @return array
     */
    public function getPaths(): array
    {
        return $this->paths;
    }
    
    /**
     * Returns passthrough path data.
     *
     * @return array
     */
    public function getPassthroughs(): array
    {
        return $this->passthroughs;
    }
}
