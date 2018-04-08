<?php
namespace HYKY\Core;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;
use Ramsey\Uuid\Uuid;

/**
 * Services : HYKY\Core\BaseEntity
 * ----------------------------------------------------------------------
 * Base entity, serializable and extendable, most entities inherit from
 * this one.
 *
 * Defines only the basic fields commonly used by entities, like ID and
 * creation/update date.
 *
 * Inherits from `Mappable` for easy serialization/JSON conversion.
 *
 * @package     HYKY\Core
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 */
class BaseEntity extends Mappable
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
     * Unique ID (Secondary Key).
     *
     * @var string
     * @Column(type="guid",unique=true)
     */
    protected $uuid;
    
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
    
    /**
     * Soft delete status.
     *
     * @var bool
     * @Column(type="boolean",nullable=false)
     */
    protected $deleted = false;
    
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
     * Retrieve the unique identifier.
     *
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
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
    
    /**
     * Retrieve deletion status.
     *
     * @return bool
     */
    public function getDeleted(): bool
    {
        return $this->deleted;
    }
    
    // Setters
    // ------------------------------------------------------------------
    
    /**
     * Sets soft delete status.
     *
     * @param bool $deleted
     * @return $this
     */
    public function setDeleted(bool $deleted)
    {
        $this->deleted = ($deleted === true);
        return $this;
    }
    
    /**
     * Toggles soft delete status on/off.
     *
     * @return $this
     */
    public function toggleDeleted()
    {
        $this->deleted = !$this->deleted;
        return $this;
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
     * Runs only when inserting data, defines a random UUID for this entity.
     *
     * @return void
     * @PrePersist
     */
    public function defineUuid()
    {
        $uuid = Uuid::uuid4();
        $this->uuid = $uuid;
    }
    
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
