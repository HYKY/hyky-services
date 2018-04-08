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
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use HYKY\Core\BaseEntity;
use HYKY\Core\Salt;

/**
 * Services : API\Models\Entity\Users\User
 * ----------------------------------------------------------------------
 * User account entity.
 *
 * @package     API\Models\Entity\Users
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 *
 * @Entity
 * @Table(name="user")
 * @HasLifecycleCallbacks
 */
class User extends BaseEntity
{
    // Properties
    // ------------------------------------------------------------------
    
    /**
     * Username, unique, only alphanumeric and underscore characters.
     *
     * @var string
     * @Column(type="string",length=128,unique=true)
     */
    protected $username;
    
    /**
     * Password.
     *
     * @var string
     * @Column(type="string",length=128)
     */
    protected $password;
    
    /**
     * E-mail address, unique.
     *
     * @var string
     * @Column(type="string",length=255,unique=true)
     */
    protected $email;
    
    /**
     * Public/private visibility flag.
     *
     * @var bool
     * @Column(type="boolean",nullable=false)
     */
    protected $is_public = true;
    
    // Relationships
    // ------------------------------------------------------------------
    
    /**
     * Collection of attributes assigned to this user.
     *
     * @var Collection
     * @OneToMany(
     *     targetEntity="API\Models\Entity\Users\UserAttribute",
     *     mappedBy="user"
     * )
     */
    protected $attributes;
    
    /**
     * Collection of groups this user is assigned to.
     *
     * @var Collection
     * @ManyToMany(
     *     targetEntity="API\Models\Entity\Users\UserGroup",
     *     inversedBy="users"
     * )
     * @JoinTable(
     *     name="user_groups_list",
     *     joinColumns={
     *          @JoinColumn(
     *              name="user_id",
     *              referencedColumnName="id"
     *          )
     *     },
     *     inverseJoinColumns={
     *          @JoinColumn(
     *              name="group_id",
     *              referencedColumnName="id"
     *          )
     *     }
     * )
     */
    protected $groups;
    
    /**
     * User role assigned to this account. Used to check for permissions.
     *
     * @var UserRole
     * @ManyToOne(
     *     targetEntity="API\Models\Entity\Users\UserRole",
     *     inversedBy="users"
     * )
     * @JoinColumn(name="role_id",referencedColumnName="id")
     */
    protected $role;
    
    // Constructor
    // ------------------------------------------------------------------
    
    /**
     * User constructor.
     */
    public function __construct()
    {
        // Set collections
        $this->attributes = new ArrayCollection();
        $this->groups = new ArrayCollection();
    }
    
    // Getters
    // ------------------------------------------------------------------
    
    /**
     * Retrieve the username.
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }
    
    /**
     * Retrieve the password.
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
    
    /**
     * Retrieve the e-mail address.
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
    
    /**
     * Retrieve the visibility status.
     *
     * @return bool
     */
    public function getIsPublic(): bool
    {
        return $this->is_public;
    }
    
    /**
     * Returns the collection of attributes assigned to this user.
     *
     * @return Collection
     */
    public function getAttributes(): Collection
    {
        return $this->attributes;
    }
    
    /**
     * Returns the attributes as an associative array with the attribute name
     * as the key.
     *
     * @return array
     */
    public function getAttributesArray(): array
    {
        $attr = [];
        /** @var UserAttribute $attribute */
        foreach ($this->attributes as $attribute) {
            $attr[$attribute->getName()] = $attribute->getValue();
        }
        return $attr;
    }
    
    /**
     * Returns a collection of groups this user's assigned to.
     *
     * @return Collection
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }
    
    /**
     * Returns an associative array where the key is the group's slug and
     * the value its name.
     *
     * @return array
     */
    public function getGroupsArray(): array
    {
        $groups = [];
        /** @var UserGroup $group */
        foreach ($this->groups as $group) {
            $groups[$group->getSlug()] = $group->getName();
        }
        return $groups;
    }
    
    /**
     * Returns the role assigned to this user.
     *
     * @return UserRole
     */
    public function getRole(): UserRole
    {
        return $this->role;
    }
    
    /**
     * Returns the data necessary to build the JSON Web Token payload.
     *
     * IMPORTANT: STILL NEEDS OPTIMIZATION!
     *
     * @return array
     */
    public function getTokenPayload(): array
    {
        $data = $this->toArray();
        
        // DO NOT RETURN PASSWORD, EVER
        unset($data['password']);
        
        // Set attribute and group arrays
        $data['attributes'] = $this->getAttributesArray();
        $data['groups'] = $this->getGroupsArray();
        
        return $data;
    }
    
    // Setters
    // ------------------------------------------------------------------
    
    /**
     * Sets the username, is still not set.
     *
     * If set, throws an exception.
     *
     * @param string $username
     * @return $this
     * @throws \Exception
     */
    public function setUsername(string $username)
    {
        if (!$this->username) {
            $this->username = $username;
        } else {
            throw new \Exception('You cannot change your username.', 401);
        }
        return $this;
    }
    
    /**
     * Sets the password.
     *
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password)
    {
        if (trim($password) !== '') {
            $this->password = \password_hash(
                trim($password),
                PASSWORD_DEFAULT
            )."§".Salt::get();
        }
        return $this;
    }
    
    /**
     * Sets the e-mail address. Validation must occur before this method is
     * executed.
     *
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
        return $this;
    }
    
    /**
     * Sets public visibility status.
     *
     * @param bool $is_public
     * @return $this
     */
    public function setIsPublic(bool $is_public)
    {
        $this->is_public = $is_public;
        return $this;
    }
    
    /**
     * Toggles public visibility status.
     *
     * @return $this
     */
    public function toggleIsPublic()
    {
        $this->is_public = !$this->is_public;
        return $this;
    }
    
    /**
     * Assigns a role to this user.
     *
     * @param UserRole $role
     * @return $this
     */
    public function setRole(UserRole $role)
    {
        $this->role = $role;
        return $this;
    }
    
    // Collection Managers
    // ------------------------------------------------------------------
    
    /**
     * Adds attribute to user.
     *
     * @param UserAttribute $attribute
     * @return $this
     */
    public function addAttribute(UserAttribute $attribute)
    {
        $this->attributes[] = $attribute;
        return $this;
    }
    
    /**
     * Removes an attribute from this user.
     *
     * @param string $attribute_name
     * @return $this
     */
    public function removeAttribute(string $attribute_name)
    {
        /** @var UserAttribute $attribute */
        foreach ($this->attributes as $attribute) {
            if ($attribute->getName() === $attribute_name) {
                $this->attributes->removeElement($attribute);
            }
        }
        return $this;
    }
    
    /**
     * Assigns this user to a group.
     *
     * @param UserGroup $group
     * @return $this
     */
    public function addGroup(UserGroup $group)
    {
        $this->groups[] = $group;
        return $this;
    }
    
    /**
     * Unassigns this user to a group.
     *
     * @param string $group_name
     * @return $this
     */
    public function removeGroup(string $group_name)
    {
        /** @var UserGroup $group */
        foreach ($this->groups as $group) {
            if ($group->getName() === $group_name) {
                $this->groups->removeElement($group);
            }
        }
        return $this;
    }
}
