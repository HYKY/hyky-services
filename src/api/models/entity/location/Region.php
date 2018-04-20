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
 * Services : API\Models\Entity\Location\Region
 * ----------------------------------------------------------------------
 * Represents a single region inside a country.
 *
 * Takes the model from Brazil's state groups, each group forming one of
 * the country's major regions (North, Northeast, Central-West, Southeast
 * and South).
 *
 * @package     API\Models\Entity\Location
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 *
 * @Entity
 * @Table(name="location_region")
 * @HasLifecycleCallbacks
 */
class Region extends BaseProfileEntity
{
    // Properties
    // ------------------------------------------------------------------
    
    /**
     * Region name.
     *
     * @var string
     * @Column(type="string",length=128,nullable=false)
     */
    protected $name;
    
    /**
     * Region abbreviation.
     *
     * @var string
     * @Column(type="string",length=128,nullable=false)
     */
    protected $abbr;
    
    // Relationships
    // ------------------------------------------------------------------
    
    /**
     * Country this region is located.
     *
     * @var Country
     * @ManyToOne(
     *     targetEntity="API\Models\Entity\Location\Country",
     *     inversedBy="regions"
     * )
     * @JoinColumn(name="country_id",referencedColumnName="id")
     */
    protected $country;
    
    /**
     * Collection of states within this region.
     *
     * @var Collection
     * @OneToMany(
     *     targetEntity="API\Models\Entity\Location\State",
     *     mappedBy="region"
     * )
     */
    protected $states;
    
    // Constructor
    // ------------------------------------------------------------------
    
    /**
     * Region constructor.
     */
    public function __construct()
    {
        // Set collections
        $this->states = new ArrayCollection();
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
     * Retrieves the country this region is located.
     *
     * @return Country
     */
    public function getCountry(): Country
    {
        return $this->country;
    }
    
    /**
     * Retrieves a collection of states located in this region.
     *
     * @return Collection
     */
    public function getStates(): Collection
    {
        return $this->states;
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
     * Assigns this region to a country.
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
     * Assigns a state to this region.
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
     * Unassigns a state from this region.
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
}
