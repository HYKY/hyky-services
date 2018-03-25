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
 * User entity.
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
     * Username/login name.
     *
     * @var string
     * @Column(type="string",length=128,unique=true)
     */
    protected $username;

    /**
     * Hashed password
     *
     * @var string
     * @Column(type="string",length=128)
     */
    protected $password;

    /**
     * E-mail address.
     *
     * @var string
     * @Column(type="string",length=255,unique=true)
     */
    protected $email;

    /**
     * If this user's profile is public or not.
     *
     * @var bool 
     * @Column(type="boolean",nullable=false)
     */
    protected $is_public = true;

    // Relationships
    // ------------------------------------------------------------------
    
    /**
     * Attributes assigned to this user.
     *
     * @var Collection
     * @OneToMany(targetEntity="API\Models\Entity\Users\UserAttribute",mappedBy="user")
     */
    protected $attributes;
    
    /**
     * User role.
     *
     * @var UserRole
     * @ManyToOne(targetEntity="API\Models\Entity\Users\UserRole",inversedBy="users")
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
    }
    
    // Getters
    // ------------------------------------------------------------------

    /**
     * Retrieves the username.
     *
     * @return string
     */
    public function getUsername(): string 
    {
        return $this->username;
    }
    
    /**
     * Retrieves the hashed password.
     *
     * @return string
     */
    public function getPassword(): string 
    {
        return $this->password;
    }

    /**
     * Retrieves the e-mail address.
     *
     * @return string
     */
    public function getEmail(): string 
    {
        return $this->email;
    }

    /**
     * Returns the public profile status.
     *
     * @return bool
     */
    public function getIsPublic(): bool 
    {
        return $this->is_public;
    }

    /**
     * Returns all data for this user as an associative array, for use 
     * with JSON Web Token payloads.
     *
     * @return array
     */
    public function getTokenPayload(): array 
    {
        $data = $this->toArray();

        // DO NOT RETURN PASSWORD
        unset($data['password']);

        return $data;
    }
    
    // Setters
    // ------------------------------------------------------------------

    /**
     * Sets the username, when trying to set up a new username for a user 
     * that's already registered, throws an error.
     *
     * @param string $username 
     * @return $this
     * @throws \Exception
     */
    public function setUsername(string $username) 
    {
        if ($this->username !== null && $this->username !== '') {
            throw new \Exception('Username cannot be changed', 412);
        }
        $this->username = $username;
        return $this;
    }

    /**
     * Updates the password only if not empty.
     *
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password) 
    {
        if (trim($password) !== '') {
            $this->password = \password_hash(
                $password, 
                PASSWORD_DEFAULT
            ).'.'.Salt::get();
        }
        return $this;
    }

    /**
     * Updates the e-mail address.
     *
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email) 
    {
        if ($email !== '' && is_string($email)) {
            $this->email = $email;
        }
        return $this;
    }

    /**
     * Updates public visibility status.
     *
     * @param boolean $is_public 
     * @return $this
     */
    public function setIsPublic(bool $is_public) 
    {
        $this->is_public = $is_public;
        return $this;
    }
    
    /**
     * Sets the user role associated with the user.
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
     * Adds an attribute to the user's collection.
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
     * Removes a user attribute from the collection.
     *
     * @param string $attr_name
     * @return $this
     */
    public function removeAttribute(string $attr_name) 
    {
        foreach ($this->attributes as $attr) {
            if ($attr->getName() === $attr_name) {
                $this->attributes->removeElement($attribute);
            }
        }
        return $this;
    }
}
