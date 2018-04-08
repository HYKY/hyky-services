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
 * Represents a single user role permission
 *
 * Permissions are just simple strings, which identify what the `UserRole`
 * assigned to it can do.
 *
 * Usually, roles have collections of one or more permissions.
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
     * Use descriptive names, please!
     *
     * @var string
     * @Column(type="string",length=128,unique=true)
     */
    protected $name;
    
    /**
     * Permission slug, derived from the name.
     *
     * @var string
     * @Column(type="string",length=128,unique=true)
     */
    protected $slug;
    
    // Relationships
    // ------------------------------------------------------------------
    
    /**
     * Collection of user roles this permissions is assigned to.
     *
     * @var Collection
     * @ManyToMany(
     *     targetEntity="API\Models\Entity\Users\UserRole",
     *     mappedBy="permissions"
     * )
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
     * Returns a collection of user roles this permission is assigned to.
     *
     * @return Collection
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }
    
    /**
     * Returns an associative array of roles this permission is assigned to,
     * with the role's slug as the key.
     *
     * @return array
     */
    public function getRolesArray(): array
    {
        $roles = [];
        /** @var UserRole $role */
        foreach ($this->roles as $role) {
            $roles[$role->getSlug()] = $role->getName();
        }
        return $roles;
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
     * Assigns this permission to a user role.
     *
     * @param UserRole $role
     * @return $this
     */
    public function addRole(UserRole $role)
    {
        $this->roles[] = $role;
        return $this;
    }
    
    /**
     * Unassigns this permission from the user role.
     *
     * @param string $role_name
     * @return $this
     */
    public function removeRole(string $role_name)
    {
        /** @var UserRole $role */
        foreach ($this->roles as $role) {
            if ($role->getName() === $role_name) {
                $this->roles->removeElement($role);
            }
        }
        return $this;
    }
}
