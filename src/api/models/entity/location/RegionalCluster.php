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
 * Services : API\Models\Entity\Location\RegionalCluster
 * ----------------------------------------------------------------------
 * Regional cluster entity.
 *
 * A regional cluster is a group of cities within a state.
 *
 * @package     API\Models\Entity\Location
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 *
 * @Entity
 * @Table(name="location_regional_cluster")
 * @HasLifecycleCallbacks
 */
class RegionalCluster extends BaseProfileEntity
{
    // Properties
    // ------------------------------------------------------------------
    
    /**
     * Cluster name.
     *
     * @var string
     * @Column(type="string",length=128,nullable=false)
     */
    protected $name;
    
    /**
     * Cluster abbreviation.
     *
     * @var string
     * @Column(type="string",length=128,nullable=false)
     */
    protected $abbr;
    
    /**
     * Cluster population value.
     *
     * @var int
     * @Column(type="integer",nullable=false)
     */
    protected $population = 0;
    
    // Relationships
    // ------------------------------------------------------------------
    
    /**
     * A collection of cities inside this cluster.
     *
     * @var Collection
     * @OneToMany(
     *     targetEntity="API\Models\Entity\Location\City",
     *     mappedBy="regional_cluster"
     * )
     */
    protected $cities;
    
    /**
     * State this cluster is assigned to.
     *
     * @var State
     * @ManyToOne(
     *     targetEntity="API\Models\Entity\Location\State",
     *     inversedBy="regional_clusters"
     * )
     * @JoinColumn(name="state_id",referencedColumnName="id")
     */
    protected $state;
    
    // Constructor
    // ------------------------------------------------------------------
    
    /**
     * RegionalCluster constructor.
     */
    public function __construct()
    {
        // Set collections
        $this->cities = new ArrayCollection();
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
     * Retrieves the abbreviation
     *
     * @return string
     */
    public function getAbbr(): string
    {
        return $this->abbr;
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
     * Retrieves the collection of cities within this cluster.
     *
     * @return Collection
     */
    public function getCities(): Collection
    {
        return $this->cities;
    }
    
    /**
     * Retrieves the state this cluster is assigned to.
     *
     * @return State
     */
    public function getState(): State
    {
        return $this->state;
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
     * Sets the population value.
     *
     * @param int $population
     * @return $this
     */
    public function setPopulation(int $population)
    {
        $this->population = $population;
        return $this;
    }
    
    // Relationship managers
    // ------------------------------------------------------------------
    
    /**
     * Assigns this cluster to a state.
     *
     * @param State $state
     * @return $this
     */
    public function setState(State $state)
    {
        $this->state = $state;
        return $this;
    }
    
    // Collection managers
    // ------------------------------------------------------------------
    
    /**
     * Adds a city to this cluster.
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
     * Removes a city from this cluster.
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
}
