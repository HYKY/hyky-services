<?php
namespace HYKY\Core;

/**
 * Services : HYKY\Core\ResponseError
 * ----------------------------------------------------------------------
 * Response error template, use it to send some standardized error data.
 *
 * @package     HYKY\Core
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 */
class ResponseError extends Mappable
{
    // Properties
    // ------------------------------------------------------------------
    
    /**
     * Error code, usually the HTTP request code.
     *
     * @var int
     */
    protected $code;
    
    /**
     * Error title.
     *
     * @var string
     */
    protected $title;
    
    /**
     * Error description.
     *
     * @var string
     */
    protected $description;
    
    /**
     * Response error data, stack trace or anything that might be helpful.
     *
     * @var mixed|null
     */
    protected $data = null;
    
    // Constructor
    // ------------------------------------------------------------------
    
    /**
     * ResponseError constructor.
     *
     * @param integer $code
     *      Error code, usually a HTTP request code, same as the response
     * @param string $title
     *      Error title
     * @param string $description
     *      Error description
     * @param mixed $data
     *      Optional, detailed information about the error or stack trace
     */
    public function __construct(
        int $code,
        string $title,
        string $description,
        $data = null
    ) {
        $this->code = $code;
        $this->data = $data;
        $this->title = $title;
        $this->description = $description;
    }
}
