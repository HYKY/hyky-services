<?php
namespace API\Models\Entity\Users;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\Table;
use HYKY\Core\BaseDateEntity;

/**
 * Services : API\Models\Entity\Users\UserPermission
 * ----------------------------------------------------------------------
 * Handles user permission types.
 * 
 * @package     API\Models\Entity\Users
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 * 
 * @Entity
 * @Table(name="user_permission")
 * @HasLifecycleCallbacks
 */
class UserPermission extends BaseDateEntity 
{
    // Properties
    // ------------------------------------------------------------------

    /**
     * Permission name.
     *
     * @var string
     * @Column(type="string",length=128,unique=true)
     */
    protected $name;
    
    /**
     * Permission slug.
     *
     * @var string
     * @Column(type="string",length=128,unique=true)
     */
    protected $slug;
    
    // Relationships
    // ------------------------------------------------------------------

    /**
     * Roles associated with this permission.
     *
     * @var Collection
     * @ManyToMany(targetEntity="API\Models\Entity\Users\UserRole",mappedBy="permissions")
     */
    protected $roles;

    // Constructor
    // ------------------------------------------------------------------

    /**
     * UserPermission constructor.
     */
    public function __construct() 
    {
        // Set collections
        $this->roles = new ArrayCollection();
    }
    
    // Getters
    // ------------------------------------------------------------------

    /**
     * Returns the name.
     *
     * @return string
     */
    public function getName(): string 
    {
        return $this->name;
    }

    /**
     * Returns the slug.
     *
     * @return string
     */
    public function getSlug(): string 
    {
        return $this->slug;
    }
    
    /**
     * Returns the collection of roles associated with this permission.
     *
     * @return Collection
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }

    // Setters
    // ------------------------------------------------------------------

    /**
     * Sets the name.
     *
     * @param string $name 
     * @return $this
     */
    public function setName(string $name) 
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Sets the slug.
     *
     * @param string $slug 
     * @return $this
     */
    public function setSlug(string $slug) 
    {
        $this->slug = $slug;
        return $this;
    }

    // Collection Managers
    // ------------------------------------------------------------------

    /**
     * Associates a role with this permission.
     *
     * @param UserRole $role
     * @return $this
     */
    public function addRole(UserRole $role) 
    {
        $this->roles[] = $role;
        return $this;
    }
}
