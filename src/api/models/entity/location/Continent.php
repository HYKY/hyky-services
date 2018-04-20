<?php
namespace API\Models\Entity\Location;

use HYKY\Core\BaseProfileEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

/**
 * Services : API\Models\Entity\Location\Continent
 * ----------------------------------------------------------------------
 * Continents entity.
 *
 * @package     API\Models\Entity\Location
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 *
 * @Entity
 * @Table(name="location_continent")
 * @HasLifecycleCallbacks
 */
class Continent extends BaseProfileEntity
{
    // Properties
    // ------------------------------------------------------------------
    
    /**
     * Continent name.
     *
     * @var string
     * @Column(type="string",length=128,nullable=false)
     */
    protected $name;
    
    // Relationships
    // ------------------------------------------------------------------
    
    /**
     * Collection of countries located within this continent.
     *
     * @var Collection
     * @OneToMany(
     *     targetEntity="API\Models\Entity\Location\Country",
     *     mappedBy="continent"
     * )
     */
    protected $countries;
    
    // Constructor
    // ------------------------------------------------------------------
    
    /**
     * Continent constructor.
     */
    public function __construct()
    {
        // Set collections
        $this->countries = new ArrayCollection();
    }
    
    // Getters
    // ------------------------------------------------------------------
    
    /**
     * Retrieves the continent name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
     * Retrieves a collection of countries in this continent.
     *
     * @return Collection
     */
    public function getCountries(): Collection
    {
        return $this->countries;
    }
    
    // Setters
    // ------------------------------------------------------------------
    
    /**
     * Sets the name
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
    
    // Collection managers
    // ------------------------------------------------------------------
    
    /**
     * Adds a country to this continent.
     *
     * @param Country $country
     * @return $this
     */
    public function addCountry(Country $country)
    {
        $this->countries[] = $country;
        return $this;
    }
    
    /**
     * Removes a country from this continent.
     *
     * @param int $country_id
     * @return $this
     */
    public function removeCountry(int $country_id)
    {
        /** @var Country $country */
        foreach ($this->countries as $country) {
            if ($country->getId() === $country_id) {
                $this->countries->removeElement($country);
            }
        }
        return $this;
    }
}
