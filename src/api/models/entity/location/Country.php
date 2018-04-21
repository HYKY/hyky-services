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
 * Services : API\Models\Entity\Location\Country
 * ----------------------------------------------------------------------
 * World country entity.
 *
 * @package     API\Models\Entity\Location
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 *
 * @Entity
 * @Table(name="location_country")
 * @HasLifecycleCallbacks
 */
class Country extends BaseProfileEntity
{
    // Properties
    // ------------------------------------------------------------------
    
    /**
     * Country name, the commonly used name for the country.
     *
     * @var string
     * @Column(type="string",length=255,nullable=false)
     */
    protected $name;
    
    /**
     * Full country name (formal name).
     *
     * @var string
     * @Column(type="string",length=255,nullable=false)
     */
    protected $full_name;
    
    /**
     * International 2-letter country code.
     *
     * @var string
     * @Column(type="string",length=128,nullable=false)
     */
    protected $code;
    
    /**
     * The country flag image file.
     *
     * @var string
     * @Column(type="string",length=128,nullable=true)
     */
    protected $flag;
    
    /**
     * Country population value.
     *
     * @var int
     * @Column(type="integer",nullable=false)
     */
    protected $population = 0;
    
    // Relationships
    // ------------------------------------------------------------------
    
    /**
     * A collection of address types used by this country.
     *
     * @var Collection
     * @OneToMany(
     *     targetEntity="API\Models\Entity\Location\AddressType",
     *     mappedBy="country"
     * )
     */
    protected $address_types;
    
    /**
     * Collection with all addresses in this country.
     *
     * @var Collection
     * @OneToMany(
     *     targetEntity="API\Models\Entity\Location\Address",
     *     mappedBy="country"
     * )
     */
    protected $addresses;
    
    /**
     * Collection of all the cities in this country.
     *
     * @var Collection
     * @OneToMany(
     *     targetEntity="API\Models\Entity\Location\City",
     *     mappedBy="country"
     * )
     */
    protected $cities;
    
    /**
     * Collection with all the states in this country.
     *
     * @var Collection
     * @OneToMany(
     *     targetEntity="API\Models\Entity\Location\State",
     *     mappedBy="country"
     * )
     */
    protected $states;
    
    /**
     * Collection with all regions in this country.
     *
     * @var Collection
     * @OneToMany(
     *     targetEntity="API\Models\Entity\Location\Region",
     *     mappedBy="country"
     * )
     */
    protected $regions;
    
    /**
     * Continent this country is located.
     *
     * @var Continent
     * @ManyToOne(
     *     targetEntity="API\Models\Entity\Location\Continent",
     *     inversedBy="countries"
     * )
     * @JoinColumn(name="continent_id",referencedColumnName="id")
     */
    protected $continent;
    
    // Constructor
    // ------------------------------------------------------------------
    
    /**
     * Country constructor.
     */
    public function __construct()
    {
        // Set collections
        $this->address_types = new ArrayCollection();
        $this->addresses = new ArrayCollection();
        $this->cities = new ArrayCollection();
        $this->states = new ArrayCollection();
        $this->regions = new ArrayCollection();
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
     * Retrieves the full name.
     *
     * @return string
     */
    public function getFullName(): string
    {
        return $this->full_name;
    }
    
    /**
     * Retrieves the country code.
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }
    
    /**
     * Retrieves the country flag.
     *
     * @return string
     */
    public function getFlag(): string
    {
        return $this->flag;
    }
    
    /**
     * Retrieves the population value.
     *
     * @return int
     */
    public function getPopulation(): int
    {
        return $this->population;
    }
    
    /**
     * Retrieves the continent this country is located at.
     *
     * @return Continent
     */
    public function getContinent(): Continent
    {
        return $this->continent;
    }
    
    /**
     * Retrieves the collection of addresses within the country.
     *
     * @return Collection
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }
    
    /**
     * Retrieves the cities within the country.
     *
     * @return Collection
     */
    public function getCities(): Collection
    {
        return $this->cities;
    }
    
    /**
     * Retrieves the states within the country.
     *
     * @return Collection
     */
    public function getStates(): Collection
    {
        return $this->states;
    }
    
    /**
     * Retrieves the regions within the country.
     *
     * @return Collection
     */
    public function getRegions(): Collection
    {
        return $this->regions;
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
     * Sets the full name.
     *
     * @param string $full_name
     * @return $this
     */
    public function setFullName(string $full_name)
    {
        $this->full_name = $full_name;
        return $this;
    }
    
    /**
     * Sets the country code.
     *
     * @param string $code
     * @return $this
     */
    public function setCode(string $code)
    {
        $this->code = $code;
        return $this;
    }
    
    /**
     * Sets the country flag.
     *
     * @param string $flag
     * @return $this
     */
    public function setFlag(string $flag)
    {
        $this->flag = $flag;
        return $this;
    }
    
    /**
     * Sets the population.
     *
     * @param int $population
     * @return $this
     */
    public function setPopulation(int $population)
    {
        $this->population = $population;
        return $this;
    }
    
    /**
     * Assigns this country to a continent.
     *
     * @param Continent $continent
     * @return $this
     */
    public function setContinent(Continent $continent)
    {
        $this->continent = $continent;
        return $this;
    }
    
    // Relationship managers
    // ------------------------------------------------------------------
    
    // Collection managers
    // ------------------------------------------------------------------
    
    /**
     * Assigns an address type to this country.
     *
     * @param AddressType $address_type
     * @return $this
     */
    public function addAddressType(AddressType $address_type)
    {
        $this->address_types[] = $address_type;
        return $this;
    }
    
    /**
     * Removes an address type from this country.
     *
     * @param int $address_type_id
     * @return $this
     */
    public function removeAddressType(int $address_type_id)
    {
        /** @var AddressType $address_type */
        foreach ($this->address_types as $address_type) {
            if ($address_type->getId() === $address_type_id) {
                $this->address_types->removeElement($address_type);
            }
        }
        return $this;
    }
    
    /**
     * Assigns an address to this country.
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
     * Removes an address from this country.
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
    
    /**
     * Assigns a city to this country.
     *
     * @param City $city
     * @return $this
     */
    public function addCity(City $city)
    {
        $this->cities[] = $city;
        return $this;
    }
    
    /**
     * Removes a city from this country.
     *
     * @param int $city_id
     * @return $this
     */
    public function removeCity(int $city_id)
    {
        /** @var City $city */
        foreach ($this->cities as $city) {
            if ($city->getId() === $city_id) {
                $this->cities->removeElement($city);
            }
        }
        return $this;
    }
    
    /**
     * Adds a state to this country.
     *
     * @param State $state
     * @return $this
     */
    public function addState(State $state)
    {
        $this->states[] = $state;
        return $this;
    }
    
    /**
     * Removes a state from this country.
     *
     * @param int $state_id
     * @return $this
     */
    public function removeState(int $state_id)
    {
        /** @var State $state */
        foreach ($this->states as $state) {
            if ($state->getId() === $state_id) {
                $this->states->removeElement($state);
            }
        }
        return $this;
    }
    
    /**
     * Adds a region to this country.
     *
     * @param Region $region
     * @return $this
     */
    public function addRegion(Region $region)
    {
        $this->regions[] = $region;
        return $this;
    }
    
    /**
     * Removes a region from this country.
     *
     * @param int $region_id
     * @return $this
     */
    public function removeRegion(int $region_id)
    {
        /** @var Region $region */
        foreach ($this->regions as $region) {
            if ($region->getId() === $region_id) {
                $this->regions->removeElement($region);
            }
        }
        return $this;
    }
}
