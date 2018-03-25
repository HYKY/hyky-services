<?php
namespace HYKY\Core;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;
use Ramsey\Uuid\Uuid;

/**
 * Services : HYKY\Core\BaseDateEntity
 * ----------------------------------------------------------------------
 * Serializable and extendable base entity, defines only the creation and 
 * update dates in the same way as `BaseEntity`.
 * 
 * Use it when you require dates, but doesn't require UUID or `deleted` status.
 * 
 * Declares an ID because Doctrine requires it.
 * 
 * Inherits and passes down anything from `Mappable`.
 * 
 * @package     HYKY\Core
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 */
class BaseDateEntity extends Mappable 
{
    /**
     * Numeric ID (Primary Key).
     * 
     * @var int 
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * Creation date.
     *
     * @var string
     * @Column(type="datetime")
     */
    protected $created_at;

    /**
     * Update date.
     *
     * @var string
     * @Column(type="datetime")
     */
    protected $updated_at;

    // Getters
    // ------------------------------------------------------------------

    /**
     * Returns the ID
     *
     * @return int
     */
    public function getId(): int 
    {
        return $this->id;
    }

    /**
     * Returns the creation date.
     *
     * @return string|mixed
     */
    public function getCreatedAt()   
    {
        return $this->created_at;
    }

    /**
     * Returns the update date.
     *
     * @return string|mixed
     */
    public function getUpdatedAt()  
    {
        return $this->updated_at;
    }

    // Protected Setters
    // ------------------------------------------------------------------

    /**
     * Sets the creation date.
     *
     * @param \DateTime $date 
     *      DateTime instance to be set
     * @return $this 
     */
    protected function setCreatedAt(\DateTime $date) 
    {
        $this->created_at = $date;
        return $this;
    }

    /**
     * Sets the update date.
     *
     * @param \DateTime $date 
     *      DateTime instance to be set
     * @return $this 
     */
    protected function setUpdatedAt(\DateTime $date) 
    {
        $this->updated_at = $date;
        return $this;
    }

    // Lifecycle Callbacks
    // ------------------------------------------------------------------
    
    /**
     * Sets the created and updated dates on an insert. If updating, it 
     * will set only the updated date.
     * 
     * @return void
     * @PrePersist
     * @PreUpdate
     */
    public function updateTimestamps() 
    {
        $this->setUpdatedAt(new \DateTime('now'));
        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt(new \DateTime('now'));
        }
    }
}
