<?php
namespace API\Models\Entity\Users;

use HYKY\Core\BaseEntity;
use HYKY\Core\Salt;
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

    // Relationships
    // ------------------------------------------------------------------

    // Constructor
    // ------------------------------------------------------------------

    /**
     * User constructor.
     */
    public function __construct() 
    {
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

    // Collection Managers
    // ------------------------------------------------------------------
}
