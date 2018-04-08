<?php
namespace API\Models\Entity\Users;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use HYKY\Core\BaseEntity;

/**
 * Services : API\Models\Entity\Users\UserToken
 * ----------------------------------------------------------------------
 * User token entity.
 *
 * @package     API\Models\Entity\Users
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 *
 * @Entity
 * @Table(name="user_token")
 * @HasLifecycleCallbacks
 */
class UserToken extends BaseEntity
{
    // Properties
    // ------------------------------------------------------------------
    
    /**
     * Token payload.
     *
     * @var string
     * @Column(type="text",nullable=false)
     */
    protected $token;
    
    /**
     * Expiration date as a UNIX timestamp.
     *
     * @var int
     * @Column(type="integer",nullable=false)
     */
    protected $expires_at;
    
    /**
     * Token validity status.
     *
     * @var bool
     * @Column(type="boolean",nullable=false)
     */
    protected $is_valid;
    
    // Relationships
    // ------------------------------------------------------------------
    
    /**
     * User account this token belongs to.
     *
     * @var User
     * @ManyToOne(targetEntity="API\Models\Entity\Users\User")
     * @JoinColumn(name="user_id",referencedColumnName="id")
     */
    protected $user;
    
    // Getters
    // ------------------------------------------------------------------
    
    /**
     * Retrieves the token.
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }
    
    /**
     * Retrieves expiration date.
     *
     * @return int
     */
    public function getExpiresAt(): int
    {
        return $this->expires_at;
    }
    
    /**
     * Retrieves validity status for the token.
     *
     * @return bool
     */
    public function getIsValid(): bool
    {
        return $this->is_valid;
    }
    
    /**
     * Returns the user associated with this token.
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
     * Sets the token payload value.
     *
     * @param string $token
     * @return $this
     */
    public function setToken(string $token)
    {
        $this->token = $token;
        return $this;
    }
    
    /**
     * Sets the expiration date.
     *
     * @param int $expires_at
     * @return $this
     */
    public function setExpiresAt(int $expires_at)
    {
        $this->expires_at = $expires_at;
        return $this;
    }
    
    /**
     * Sets the validity status.
     *
     * @param bool $is_valid
     * @return $this
     */
    public function setIsValid(bool $is_valid)
    {
        $this->is_valid = $is_valid;
        return $this;
    }
    
    /**
     * Assigns this token to a user.
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
