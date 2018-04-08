<?php
namespace HYKY\Core;

/**
 * Services : HYKY\Core\ClientInformation
 * ----------------------------------------------------------------------
 * Defines a serializable object containing the user client information.
 *
 * @package     HYKY\Core
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 */
class ClientInformation extends Mappable
{
    // Properties
    // ------------------------------------------------------------------
    
    /**
     * HTTP User Agent.
     *
     * @var string
     */
    protected $http_user_agent;
    
    /**
     * HTTP Connection.
     *
     * @var string
     */
    protected $http_connection;
    
    /**
     * HTTP Host.
     *
     * @var string
     */
    protected $http_host;
    
    /**
     * HTTP Referer.
     *
     * @var string
     */
    protected $http_referer;
    
    /**
     * Remote user IP address.
     *
     * @var string
     */
    protected $remote_addr;
    
    /**
     * Remote user hostname.
     *
     * @var string
     */
    protected $remote_host;
    
    /**
     * HTTP request method.
     *
     * @var string
     */
    protected $request_method;
    
    /**
     * Server request URI.
     *
     * @var string
     */
    protected $request_uri;
    
    /**
     * Date for this information retrieval.
     *
     * @var false|null|string
     */
    protected $date = null;
    
    // Constructor
    // ------------------------------------------------------------------
    
    /**
     * ClientInformation constructor.
     *
     * @param boolean $with_date
     *      Optional, for debugging purposes, should date
     *      be included?
     */
    public function __construct(bool $with_date = false)
    {
        $this->http_user_agent = (isset($_SERVER['HTTP_USER_AGENT']))
            ? $_SERVER['HTTP_USER_AGENT'] : null;
        $this->http_connection = (isset($_SERVER['HTTP_CONNECTION']))
            ? $_SERVER['HTTP_CONNECTION'] : null;
        $this->http_host = (isset($_SERVER['HTTP_HOST']))
            ? $_SERVER['HTTP_HOST'] : null;
        $this->http_referer = (isset($_SERVER['HTTP_REFERER']))
            ? $_SERVER['HTTP_REFERER'] : null;
        $this->remote_addr = (isset($_SERVER['REMOTE_ADDR']))
            ? $_SERVER['REMOTE_ADDR'] : null;
        $this->remote_host = (isset($_SERVER['REMOTE_HOST']))
            ? $_SERVER['REMOTE_HOST'] : null;
        $this->request_method = (isset($_SERVER['REQUEST_METHOD']))
            ? $_SERVER['REQUEST_METHOD'] : null;
        $this->request_uri = (isset($_SERVER['REQUEST_URI']))
            ? $_SERVER['REQUEST_URI'] : null;
        if ($with_date === true) $this->date = date('c');
    }
}
