<?php
namespace API\Models\Entity\Location;

use HYKY\Core\BaseProfileEntity;
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
 * Services : API\Models\Entity\Location\District
 * ----------------------------------------------------------------------
 * City districts entity.
 *
 * @package     API\Models\Entity\Location
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 *
 * @Entity
 * @Table(name="location_district")
 * @HasLifecycleCallbacks
 */
class District extends BaseProfileEntity
{
    // Properties
    // ------------------------------------------------------------------
    
    /**
     * District name.
     *
     * @var string
     * @Column(type="string",length=128,nullable=false)
     */
    protected $name;
    
    // Relationships
    // ------------------------------------------------------------------
    
    /**
     * Collection of addresses in this district.
     *
     * @var Collection
     * @OneToMany(
     *     targetEntity="API\Models\Entity\Location\Address",
     *     mappedBy="district"
     * )
     */
    protected $addresses;
    
    /**
     * City where this district is located.
     *
     * @var City
     * @ManyToOne(
     *     targetEntity="API\Models\Entity\Location\City",
     *     inversedBy="districts"
     * )
     * @JoinColumn(name="city_id",referencedColumnName="id")
     */
    protected $city;
    
    // Constructor
    // ------------------------------------------------------------------
    
    /**
     * District constructor.
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
     * Retrieves a collection of addresses located in this district.
     *
     * @return Collection
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }
    
    /**
     * Returns the city.
     *
     * @return City
     */
    public function getCity(): City
    {
        return $this->city;
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
    
    // Relationship managers
    // ------------------------------------------------------------------
    
    /**
     * Assigns the district to a city.
     *
     * @param City $city
     * @return $this
     */
    public function setCity(City $city)
    {
        $this->city = $city;
        return $this;
    }
    
    // Collection managers
    // ------------------------------------------------------------------
    
    /**
     * Assigns an address to this district.
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
     * Removes an address from this district.
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
