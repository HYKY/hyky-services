<?php
namespace API\Models\Entity\Location;

use HYKY\Core\BaseEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

/**
 * Services : API\Models\Entity\Location\Address
 * ----------------------------------------------------------------------
 * Handles address types.
 *
 * Among these, for example in Brazil, we have:
 * - Rua (Street)
 * - Avenida (Avenue)
 * - Praça (Square)
 * - and so on...
 *
 * Types may have an abbreviated form, which is optional.
 *
 * @package     API\Models\Entity\Location
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 *
 * @Entity
 * @Table(name="location_address_type")
 * @HasLifecycleCallbacks
 */
class AddressType extends BaseEntity
{
    // Properties
    // ------------------------------------------------------------------
    
    /**
     * Address type name.
     *
     * @var string
     * @Column(type="string",length=128,nullable=false)
     */
    protected $name;
    
    /**
     * Abbreviated term, optional.
     *
     * @var string
     * @Column(type="string",128,nullable=true)
     */
    protected $abbr;
    
    // Relationships
    // ------------------------------------------------------------------
    
    /**
     * A collection of addresses assigned to this type.
     *
     * @var Collection
     * @OneToMany(
     *     targetEntity="API\Models\Entity\Location\Address",
     *     mappedBy="address_type"
     * )
     */
    protected $addresses;
    
    /**
     * Country this address type is used.
     *
     * @var Country
     * @ManyToOne(
     *     targetEntity="API\Models\Entity\Location\Country",
     *     inversedBy="address_types"
     * )
     * @JoinColumn(name="country_id",referencedColumnName="id")
     */
    protected $country;
    
    // Constructor
    // ------------------------------------------------------------------
    
    /**
     * AddressType constructor.
     */
    public function __construct()
    {
        // Set collections
        $this->addresses = new ArrayCollection();
    }
    
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
     * Retrieves the abbreviation.
     *
     * @return string
     */
    public function getAbbr(): string
    {
        return $this->abbr;
    }
    
    /**
     * Retrieves the collection of addresses assigned to this type.
     *
     * @return Collection
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }
    
    /**
     * Retrieves the country this type is used.
     *
     * @return Country
     */
    public function getCountry(): Country
    {
        return $this->country;
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
     * Sets the abbreviation.
     *
     * @param string $abbr
     * @return $this
     */
    public function setAbbr(string $abbr)
    {
        $this->abbr = $abbr;
        return $this;
    }
    
    // Relationship managers
    // ------------------------------------------------------------------
    
    /**
     * Assigns this type to a country.
     *
     * @param Country $country
     * @return $this
     */
    public function setCountry(Country $country)
    {
        $this->country = $country;
        return $this;
    }
    
    // Collection managers
    // ------------------------------------------------------------------
    
    /**
     * Assigns an address to this type.
     *
     * @param Address $address
     * @return $this
     */
    public function addAddress(Address $address)
    {
        $this->addresses[] = $address;
        return $this;
    }
    
    /**
     * Unassigns an address from this type.
     *
     * @param int $address_id
     * @return $this
     */
    public function removeAddress(int $address_id)
    {
        /** @var Address $address */
        foreach ($this->addresses as $address) {
            if ($address->getId() === $address_id) {
                $this->addresses->removeElement($address);
            }
        }
        return $this;
    }
}
