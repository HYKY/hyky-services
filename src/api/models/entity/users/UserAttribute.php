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
 * User attribute entity, represents a single attribute.
 *
 * A user can have one or more attributes in a `Collection`.
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
     * @var string
     * @Column(type="string",length=128,nullable=false)
     */
    protected $name;
    
    /**
     * Attribute value.
     *
     * @var string
     * @Column(type="string",length=255,nullable=true)
     */
    protected $value;
    
    // Relationships
    // ------------------------------------------------------------------
    
    /**
     * User associated with the attribute.
     *
     * @var User
     * @ManyToOne(
     *     targetEntity="API\Models\Entity\Users\User",
     *     inversedBy="attributes"
     * )
     * @JoinColumn(name="user_id",referencedColumnName="id")
     */
    protected $user;
    
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
     * Retrieve the value.
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
    
    /**
     * Retrieve the user associated with this attribute.
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
     * Sets the attribute name.
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
     * Sets the attribute value.
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
     * Assigns this attribute to a user.
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
