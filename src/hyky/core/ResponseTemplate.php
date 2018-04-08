<?php
namespace HYKY\Core;

/**
 * Services : HYKY\Core\ResponseTemplate
 * ----------------------------------------------------------------------
 * Serializable response template object, use it to standardize JSON
 * responses.
 *
 * @package     HYKY\Core
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 */
class ResponseTemplate extends Mappable
{
    // Properties
    // ------------------------------------------------------------------
    
    /**
     * Response HTTP code.
     *
     * @var int
     */
    protected $code;
    
    /**
     * Response payload.
     *
     * @var array
     */
    protected $result;
    
    /**
     * Client information object.
     *
     * @var ClientInformation
     */
    protected $client;
    
    // Constructor
    // ------------------------------------------------------------------
    
    /**
     * ResponseTemplate constructor
     *
     * @param integer $code
     *      Replicates the HTTP response code
     * @param array|object $result
     *      Response payload data
     * @param bool $client
     *      Optional, set it to TRUE to return the user client information
     */
    public function __construct(
        int $code,
        $result,
        bool $client = false
    ) {
        $this->code = $code;
        $this->result = $result;
        $this->client = ($client === true)
            ? (new ClientInformation())->toArray() : [];
    }
}
