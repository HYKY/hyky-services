<?php
namespace API\Models\Entity;

use HYKY\Core\BaseEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

/**
 * Services : API\Models\Entity\Dummy
 * ----------------------------------------------------------------------
 * Blank, dummy entity.
 * 
 * @package     API\Models\Entity
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 */
class DummyEntity extends BaseEntity 
{
    // Properties
    // ------------------------------------------------------------------
    
    // Relationships
    // ------------------------------------------------------------------

    // Constructor
    // ------------------------------------------------------------------

    /**
     * Dummy constructor.
     */
    public function __construct() 
    {
    }
    
    // Getters
    // ------------------------------------------------------------------

    // Setters
    // ------------------------------------------------------------------

    // Collection Managers
    // ------------------------------------------------------------------
}
