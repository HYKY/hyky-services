<?php
namespace HYKY\Core;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;

/**
 * Services : HYKY\Core\BaseDateEntity
 * ----------------------------------------------------------------------
 * Base entity, serializable and extendable, similar to `BaseEntity`.
 *
 * Extend from this entity when you only require creation/update dates, but
 * doesn't require UUID and soft-delete status.
 *
 * It still declares an ID because Doctrine requires at least a primary key.
 *
 * Inherits from `Mappable` for easy serialization/JSON conversion.
 *
 * @package     HYKY\Core
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 */
class BaseDateEntity extends Mappable
{
    // Properties
    // ------------------------------------------------------------------
    
    /**
     * Numeric ID (Primary Key)
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
     * Retrieve the ID.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
    
    /**
     * Retrieve the creation date.
     *
     * @return string|mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    
    /**
     * Retrieve the updated date.
     *
     * @return string|mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
    
    // Protected setters
    // ------------------------------------------------------------------
    
    /**
     * Sets creation date.
     *
     * @param \DateTime $date
     * @return $this
     */
    protected function setCreatedAt(\DateTime $date)
    {
        $this->created_at = $date;
        return $this;
    }
    
    /**
     * Sets update date.
     *
     * @param \DateTime $date
     * @return $this
     */
    protected function setUpdatedAt(\DateTime $date)
    {
        $this->updated_at = $date;
        return $this;
    }
    
    // Lifecycle callbacks
    // ------------------------------------------------------------------
    
    /**
     * Sets creation and update dates on this entity. When updating, only
     * the updated date will be set.
     *
     * @return void
     * @PrePersist
     * @PreUpdate
     */
    public function updateTimeStamps()
    {
        $this->setUpdatedAt(new \DateTime('now'));
        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt(new \DateTime('now'));
        }
    }
}
