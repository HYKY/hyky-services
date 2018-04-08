<?php
namespace API\Models\Entity\Users;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\Table;
use HYKY\Core\BaseEntity;

/**
 * Services : API\Models\Entity\Users\UserGroup
 * ----------------------------------------------------------------------
 * User group entity.
 *
 * A user can be assigned to one or more groups.
 *
 * @package     API\Models\Entity\Users
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 *
 * @Entity
 * @Table(name="user_group")
 * @HasLifecycleCallbacks
 */
class UserGroup extends BaseEntity
{
    // Properties
    // ------------------------------------------------------------------
    
    /**
     * Group name.
     *
     * @var string
     * @Column(type="string",length=128,nullable=false,unique=true)
     */
    protected $name;
    
    /**
     * Group slug.
     *
     * @var string
     * @Column(type="string",length=128,nullable=false,unique=true)
     */
    protected $slug;
    
    /**
     * Group short description.
     *
     * @var string
     * @Column(type="string",length=255,nullable=true)
     */
    protected $description;
    
    /**
     * Group image file name
     *
     * @var string
     * @Column(type="string",length=128,nullable=true)
     */
    protected $image = null;
    
    /**
     * Public visibility status.
     *
     * @var bool
     * @Column(type="boolean",nullable=false)
     */
    protected $is_public = true;
    
    /**
     * Group protection status.
     *
     * Protected groups can only be edited by administrators.
     *
     * @var bool
     * @Column(type="boolean",nullable=false)
     */
    protected $is_protected = false;
    
    // Relationships
    // ------------------------------------------------------------------
    
    /**
     * Collection of users assigned to this group.
     *
     * @var Collection
     * @ManyToMany(
     *     targetEntity="API\Models\Entity\Users\User",
     *     mappedBy="groups"
     * )
     */
    protected $users;
    
    // Constructor
    // ------------------------------------------------------------------
    
    /**
     * UserGroup constructor.
     */
    public function __construct()
    {
        // Set collection
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
     * Retrieve the image file name.
     *
     * @return string|null
     */
    public function getImage(): string
    {
        return $this->image;
    }
    
    /**
     * Returns public visibility status.
     *
     * @return bool
     */
    public function getIsPublic(): bool
    {
        return $this->is_public;
    }
    
    /**
     * Retrieve the protected status.
     *
     * @return bool
     */
    public function getIsProtected(): bool
    {
        return $this->is_protected;
    }
    
    /**
     * Returns a collection of users assigned to this group..
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
    
    /**
     * Sets the short description.
     *
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
        return $this;
    }
    
    /**
     * Sets the image file name.
     *
     * @param string $image
     * @return $this
     */
    public function setImage(string $image)
    {
        $this->image = $image;
        return $this;
    }
    
    /**
     * Sets the public visibility status.
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
     * Sets the protection status.
     *
     * @param bool $is_protected
     * @return $this
     */
    public function setIsProtected(bool $is_protected)
    {
        $this->is_protected = $is_protected;
        return $this;
    }
    
    // Collection Managers
    // ------------------------------------------------------------------
    
    /**
     * Assigns this user to this group.
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
     * Unassigns a user from this group.
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
