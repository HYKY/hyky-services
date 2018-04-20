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
 * Services : API\Models\Entity\Location\State
 * ----------------------------------------------------------------------
 * Country state entity.
 *
 * @package     API\Models\Entity\Location
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 *
 * @Entity
 * @Table(name="location_state")
 * @HasLifecycleCallbacks
 */
class State extends BaseProfileEntity
{
    // Properties
    // ------------------------------------------------------------------
    
    /**
     * State name.
     *
     * @var string
     * @Column(type="string",length=128,nullable=false)
     */
    protected $name;
    
    /**
     * State abbreviation.
     *
     * @var string
     * @Column(type="string",length=128,nullable=false)
     */
    protected $abbr;
    
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
     * Collection of all addresses within this state.
     *
     * @var Collection
     * @OneToMany(
     *     targetEntity="API\Models\Entity\Location\Address",
     *     mappedBy="state"
     * )
     */
    protected $addresses;
    
    /**
     * Collection of cities located within this state.
     *
     * @var Collection
     * @OneToMany(
     *     targetEntity="API\Models\Entity\Location\City",
     *     mappedBy="state"
     * )
     */
    protected $cities;
    
    /**
     * Collection of regional clusters of cities locates within this state.
     *
     * @var Collection
     * @OneToMany(
     *     targetEntity="API\Models\Entity\Location\RegionalCluster",
     *     mappedBy="state"
     * )
     */
    protected $regional_clusters;
    
    /**
     * Region this state is assigned to.
     *
     * @var Region
     * @ManyToOne(
     *     targetEntity="API\Models\Entity\Location\Region",
     *     inversedBy="states"
     * )
     * @JoinColumn(name="region_id",referencedColumnName="id")
     */
    protected $region;
    
    /**
     * Country this state is located.
     *
     * @var Country
     * @ManyToOne(
     *     targetEntity="API\Models\Entity\Location\Country",
     *     inversedBy="states"
     * )
     * @JoinColumn(name="country_id",referencedColumnName="id")
     */
    protected $country;
    
    // Constructor
    // ------------------------------------------------------------------
    
    /**
     * State constructor.
     */
    public function __construct()
    {
        // Set collections
        $this->addresses = new ArrayCollection();
        $this->cities = new ArrayCollection();
        $this->regional_clusters = new ArrayCollection();
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
     * Retrieves the collection of cities within this state.
     *
     * @return Collection
     */
    public function getCities(): Collection
    {
        return $this->cities;
    }
    
    /**
     * Retrieves the collection of regional clusters within this state.
     *
     * @return Collection
     */
    public function getRegionalClusters(): Collection
    {
        return $this->regional_clusters;
    }
    
    /**
     * Retrieves the region this state is located in.
     *
     * @return Region
     */
    public function getRegion(): Region
    {
        return $this->region;
    }
    
    /**
     * Retrieves the country this state is located in.
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
     * Sets the pinned order value.
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
     * Assign this state to a region.
     *
     * @param Region $region
     * @return $this
     */
    public function setRegion(Region $region)
    {
        $this->region = $region;
        return $this;
    }
    
    /**
     * Assign this state to a country.
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
     * Assigns an address to this state.
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
     * Removes an address from this state.
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
     * Assigns a city to this state.
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
     * Removes a city from this state.
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
     * Assigns a regional cluster to this state.
     *
     * @param RegionalCluster $regional_cluster
     * @return $this
     */
    public function addRegionalCluster(RegionalCluster $regional_cluster)
    {
        $this->regional_clusters[] = $regional_cluster;
        return $this;
        
    }
    
    /**
     * Removes a regional cluster from this state.
     *
     * @param int $regional_cluster_id
     * @return $this
     */
    public function removeRegionalCluster(int $regional_cluster_id)
    {
        /** @var RegionalCluster $regional_cluster */
        foreach ($this->regional_clusters as $regional_cluster) {
            if ($regional_cluster->getId() === $regional_cluster_id) {
                $this->regional_clusters->removeElement($regional_cluster);
            }
        }
        return $this;
    }
}
