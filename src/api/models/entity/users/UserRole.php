<?php
namespace API\Models\Entity\Users;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use HYKY\Core\BaseDateEntity;

/**
 * Services : API\Models\Entity\Users\UserRole
 * ----------------------------------------------------------------------
 * Represents a single user role. A user can have only a single role assigned
 * to it.
 *
 * @package     API\Models\Entity\Users
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 *
 * @Entity
 * @Table(name="user_role")
 * @HasLifecycleCallbacks
 */
class UserRole extends BaseDateEntity
{
    // Properties
    // ------------------------------------------------------------------
    
    /**
     * Role name.
     *
     * @var string
     * @Column(type="string",length=128,unique=true)
     */
    protected $name;
    
    /**
     * Role slug.
     *
     * @var string
     * @Column(type="string",length=128,unique=true)
     */
    protected $slug;
    
    /**
     * Role description.
     *
     * @var string
     * @Column(type="string",length=128,nullable=true)
     */
    protected $description;
    
    // Relationships
    // ------------------------------------------------------------------
    
    /**
     * Collection of permissions allowed to this role.
     *
     * @var Collection
     * @ManyToMany(
     *     targetEntity="API\Models\Entity\Users\UserPermission",
     *     inversedBy="roles"
     * )
     * @JoinTable(
     *     name="user_role_permission",
     *     joinColumns={
     *          @JoinColumn(name="role_id",referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *          @JoinColumn(name="permission_id",referencedColumnName="id")
     *     }
     * )
     */
    protected $permissions;
    
    /**
     * Collection of users this role's assigned to.
     *
     * @var Collection
     * @OneToMany(
     *     targetEntity="API\Models\Entity\Users\User",
     *     mappedBy="role"
     * )
     */
    protected $users;
    
    // Constructor
    // ------------------------------------------------------------------
    
    /**
     * UserRole constructor.
     */
    public function __construct()
    {
        // Set collections
        $this->permissions = new ArrayCollection();
        $this->users = new ArrayCollection();
    }
    
    // Getters
    // ------------------------------------------------------------------
    
    /**
     * Retrieve the name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
     * Retrieve the slug.
     *
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }
    
    /**
     * Retrieve the description.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
    
    /**
     * Returns a collection of permissions assigned to this role.
     *
     * @return Collection
     */
    public function getPermissions(): Collection
    {
        return $this->permissions;
    }
    
    /**
     * Returns an associative array with the permission slug as the key and
     * name as value.
     *
     * @return array
     */
    public function getPermissionsArray(): array
    {
        $permissions = [];
        /** @var UserPermission $permission */
        foreach ($this->permissions as $permission) {
            $permissions[$permission->getSlug()] = $permission->getName();
        }
        return $permissions;
    }
    
    /**
     * Returns a collection of users this role's assigned to.
     *
     * @return Collection
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }
    
    /**
     * Returns an associative array of users, where the username is the key
     * and the e-mail address is the value.
     *
     * @return array
     */
    public function getUsersArray(): array
    {
        $users = [];
        /** @var User $user */
        foreach ($this->users as $user) {
            $users[$user->getUsername()] = $user->getEmail();
        }
        return $users;
    }
    
    // Setters
    // ------------------------------------------------------------------
    
    /**
     * Set the name.
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
     * Set the slug.
     *
     * @param string $slug
     * @return $this
     */
    public function setSlug(string $slug)
    {
        $this->slug = $slug;
        return $this;
    }
    
    /**
     * Set the description.
     *
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
        return $this;
    }
    
    // Collection Managers
    // ------------------------------------------------------------------
    
    /**
     * Add a permission to this role's collection.
     *
     * @param UserPermission $permission
     * @return $this
     */
    public function addPermission(UserPermission $permission)
    {
        $this->permissions[] = $permission;
        return $this;
    }
    
    /**
     * Removes a permission from this role's collection.
     *
     * @param string $permission_name
     * @return $this
     */
    public function removePermission(string $permission_name)
    {
        /** @var UserPermission $permission */
        foreach ($this->permissions as $permission) {
            if ($permission->getName() === $permission_name) {
                $this->permissions->removeElement($permission);
            }
        }
        return $this;
    }
    
    /**
     * Assigns this role to a user.
     *
     * @param User $user
     * @return $this
     */
    public function addUser(User $user)
    {
        $this->users[] = $user;
        return $this;
    }
    
    /**
     * Unassigns this role from the user.
     *
     * @param string $username
     * @return $this
     */
    public function removeUser(string $username)
    {
        /** @var User $user */
        foreach ($this->users as $user) {
            if ($user->getUsername() === $username) {
                $this->users->removeElement($user);
            }
        }
        return $this;
    }
}
