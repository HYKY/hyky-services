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
 * Services : API\Models\Entity\Location\City
 * ----------------------------------------------------------------------
 * City entity.
 *
 * @package     API\Models\Entity\Location
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 *
 * @Entity
 * @Table(name="location_city")
 * @HasLifecycleCallbacks
 */
class City extends BaseProfileEntity
{
    // Properties
    // ------------------------------------------------------------------
    
    /**
     * City name.
     *
     * @var string
     * @Column(type="string",length=255,nullable=false)
     */
    protected $name;
    
    /**
     * City population value.
     *
     * @var int
     * @Column(type="integer",nullable=false)
     */
    protected $population = 0;
    
    /**
     * Pinned status.
     *
     * Pinned entities have priority over other entities when listing.
     *
     * @var bool
     * @Column(type="boolean",nullable=false)
     */
    protected $pinned = false;
    
    /**
     * Pinned status order.
     *
     * Pinned entities can also have an ascending order.
     *
     * @var int
     * @Column(type="integer",nullable=false)
     */
    protected $pinned_order = 0;
    
    // Relationships
    // ------------------------------------------------------------------
    
    /**
     * Collection of addresses located in this city.
     *
     * @var Collection
     * @OneToMany(
     *     targetEntity="API\Models\Entity\Location\Address",
     *     mappedBy="city"
     * )
     */
    protected $addresses;
    
    /**
     * Collection of districts located in this city.
     *
     * @var Collection
     * @OneToMany(
     *     targetEntity="API\Models\Entity\Location\District",
     *     mappedBy="city"
     * )
     */
    protected $districts;
    
    /**
     * Regional cluster this city belongs to.
     *
     * @var RegionalCluster
     * @ManyToOne(
     *     targetEntity="API\Models\Entity\Location\RegionalCluster",
     *     inversedBy="cities"
     * )
     * @JoinColumn(name="regional_cluster_id",referencedColumnName="id")
     */
    protected $regional_cluster;
    
    /**
     * State this city is located in.
     *
     * @var State
     * @ManyToOne(
     *     targetEntity="API\Models\Entity\Location\State",
     *     inversedBy="cities"
     * )
     * @JoinColumn(name="state_id",referencedColumnName="id")
     */
    protected $state;
    
    /**
     * Country this city belongs to.
     *
     * @var Country
     * @ManyToOne(
     *     targetEntity="API\Models\Entity\Location\Country",
     *     inversedBy="cities"
     * )
     * @JoinColumn(name="country_id",referencedColumnName="id")
     */
    protected $country;
    
    /**
     * Collection of landmarks located in this city.
     *
     * @var Collection
     * @OneToMany(
     *     targetEntity="API\Models\Entity\Location\Landmark",
     *     mappedBy="city"
     * )
     */
    protected $landmarks;
    
    // Constructor
    // ------------------------------------------------------------------
    
    /**
     * City constructor.
     */
    public function __construct()
    {
        // Set collections
        $this->addresses = new ArrayCollection();
        $this->districts = new ArrayCollection();
        $this->landmarks = new ArrayCollection();
    }
    
    // Getters
    // ------------------------------------------------------------------
    
    /**
     * Retrieves the city name.
     *
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }
    
    /**
     * Retrieves the population value.
     *
     * @return int
     */
    public function getPopulation(): int {
        return $this->population;
    }
    
    /**
     * Retrieves the pinned status.
     *
     * @return bool
     */
    public function getPinned(): bool
    {
        return $this->pinned;
    }
    
    /**
     * Retrieves the pinned order value.
     *
     * @return int
     */
    public function getPinnedOrder(): int
    {
        return $this->pinned_order;
    }
    
    /**
     * Retrieves a collection of addresses located in this city.
     *
     * @return Collection
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }
    
    /**
     * Retrieves the collection of districts located within this city.
     *
     * @return Collection
     */
    public function getDistricts(): Collection
    {
        return $this->districts;
    }
    
    /**
     * Retrieves the regional cluster this city belongs to.
     *
     * @return RegionalCluster
     */
    public function getRegionalCluster(): RegionalCluster
    {
        return $this->regional_cluster;
    }
    
    /**
     * Retrieves the state this city belongs to.
     *
     * @return State
     */
    public function getState(): State
    {
        return $this->state;
    }
    
    /**
     * Retrieves the country this city belongs to.
     *
     * @return Country
     */
    public function getCountry(): Country
    {
        return $this->country;
    }
    
    /**
     * Retrieves the collection of landmarks in this city.
     *
     * @return Collection
     */
    public function getLandmarks(): Collection
    {
        return $this->landmarks;
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
     * Sets the pinned status.
     *
     * @param bool $pinned
     * @return $this
     */
    public function setPinned(bool $pinned)
    {
        $this->pinned = $pinned;
        return $this;
    }
    
    /**
     * Toggles pinned status.
     *
     * @return $this
     */
    public function togglePinned()
    {
        $this->pinned = !$this->pinned;
        return $this;
    }
    
    /**
     * Sets the pinned order.
     *
     * @param int $pinned_order
     * @return $this
     */
    public function setPinnedOrder(int $pinned_order)
    {
        $this->pinned_order = $pinned_order;
        return $this;
    }
    
    // Relationship managers
    // ------------------------------------------------------------------
    
    /**
     * Assigns the city to a regional cluster.
     *
     * @param RegionalCluster $regional_cluster
     * @return $this
     */
    public function setRegionalCluster(RegionalCluster $regional_cluster)
    {
        $this->regional_cluster = $regional_cluster;
        return $this;
    }
    
    /**
     * Assigns the city to a state.
     *
     * @param State $state
     * @return $this
     */
    public function setState(State $state)
    {
        $this->state = $state;
        return $this;
    }
    
    /**
     * Assigns the city to a country.
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
     * Assigns an address to this city.
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
     * Removes an address from this city.
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
     * Assigns a district to this city.
     *
     * @param District $district
     * @return $this
     */
    public function addDistrict(District $district)
    {
        $this->districts[] = $district;
        return $this;
    }
    
    /**
     * Removes a district from this city.
     *
     * @param int $district_id
     * @return $this
     */
    public function removeDistrict(int $district_id)
    {
        /** @var District $district */
        foreach ($this->districts as $district) {
            if ($district->getId() === $district_id) {
                $this->districts->removeElement($district);
            }
        }
        return $this;
    }
    
    /**
     * Adds a landmark to this city.
     *
     * @param Landmark $landmark
     * @return $this
     */
    public function addLandmark(Landmark $landmark)
    {
        $this->landmarks[] = $landmark;
        return $this;
    }
    
    /**
     * Removes a landmark from this city.
     *
     * @param int $landmark_id
     * @return $this
     */
    public function removeLandmark(int $landmark_id)
    {
        /** @var Landmark $landmark */
        foreach ($this->landmarks as $landmark) {
            if ($landmark->getId() === $landmark_id) {
                $this->landmarks->removeElement($landmark);
            }
        }
        return $this;
    }
}
