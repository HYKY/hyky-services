<?php
namespace API\Models\Entity\Users;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use HYKY\Core\BaseDateEntity;

/**
 * Services : API\Models\Entity\Users\UserAttribute
 * ----------------------------------------------------------------------
 * Handles user attribute collections.
 * 
 * @package     API\Models\Entity\Users
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 * 
 * @Entity
 * @Table(name="user_attribute")
 * @HasLifecycleCallbacks
 */
class UserAttribute extends BaseDateEntity 
{
    // Properties
    // ------------------------------------------------------------------

    /**
     * Attribute name.
     * 
     * Naming rules are the same as PHP's naming rules.
     *
     * @var string
     * @Column(type="string",length=128,nullable=false)
     */
    protected $name;

    /**
     * Entity value.
     *
     * @var string
     */
    protected $value;

    // Relationships
    // ------------------------------------------------------------------

    /**
     * User this attribute is assigned with.
     *
     * @var User
     * @ManyToOne(targetEntity="API\Models\Entity\Users\User",inversedBy="attributes")
     * @JoinColumn(name="user_id",referencedColumnName="id")
     */
    protected $user;

    // Getters
    // ------------------------------------------------------------------

    /**
     * Retrieves the name.
     *
     * @return string
     */
    public function getName(): string  
    {
        return $this->name;
    }

    /**
     * Retrieves the value.
     *
     * @return string
     */
    public function getValue(): string  
    {
        return $this->value;
    }

    /**
     * Returns the attribute as a [name => value] array.
     *
     * @return array
     */
    public function getAttribute(): array 
    {
        return [$this->name => $this->value];
    }

    /**
     * Returns the user this attribute is assigned to.
     *
     * @return User
     */
    public function getUser(): User 
    {
        return $this->user;
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
     * Sets the value.
     *
     * @param string $value
     * @return $this
     */
    public function setValue(string $value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Assigns to an user.
     *
     * @param User $user
     * @return $this
     */
    public function setUser(User $user) 
    {
        $this->user = $user;
        return $this;
    }
}
