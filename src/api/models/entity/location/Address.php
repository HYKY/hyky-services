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
 * Address entity.
 *
 * An address is usually a combination of Street/Avenue/Etc. with a ZIP code.
 *
 * @package     API\Models\Entity\Location
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 *
 * @Entity
 * @Table(name="location_address")
 * @HasLifecycleCallbacks
 */
class Address extends BaseEntity
{
    // Properties
    // ------------------------------------------------------------------
    
    /**
     * Address name.
     *
     * @var string
     * @Column(type="string",length=255,nullable=false)
     */
    protected $name;
    
    /**
     * ZIP code attached to this address.
     *
     * It's nullable and optional because in countries like Brazil, an
     * airport is considered an "address" (albeit a kinda a "virtual" one).
     *
     * @var string
     * @Column(type="string",length=64,nullable=true)
     */
    protected $zip;
    
    // Relationships
    // ------------------------------------------------------------------
    
    /**
     * The address type assigned to this address.
     *
     * @var AddressType
     * @ManyToOne(
     *     targetEntity="API\Models\Entity\Location\AddressType",
     *     inversedBy="addresses"
     * )
     * @JoinColumn(name="address_type_id",referencedColumnName="id")
     */
    protected $address_type;
    
    /**
     * District this address is located in.
     *
     * @var District
     * @ManyToOne(
     *     targetEntity="API\Models\Entity\Location\City",
     *     inversedBy="addresses"
     * )
     * @JoinColumn(name="district_id",referencedColumnName="id")
     */
    protected $district;
    
    /**
     * City this address is located in.
     *
     * @var City
     * @ManyToOne(
     *     targetEntity="API\Models\Entity\Location\City",
     *     inversedBy="addresses"
     * )
     * @JoinColumn(name="city_id",referencedColumnName="id")
     */
    protected $city;
    
    /**
     * State this address is located in.
     *
     * @var State
     * @ManyToOne(
     *     targetEntity="API\Models\Entity\Location\State",
     *     inversedBy="addresses"
     * )
     * @JoinColumn(name="state_id",referencedColumnName="id")
     */
    protected $state;
    
    /**
     * Country this address is located in.
     *
     * @var Country
     * @ManyToOne(
     *     targetEntity="API\Models\Entity\Location\Country",
     *     inversedBy="addresses"
     * )
     * @JoinColumn(name="country_id",referencedColumnName="id")
     */
    protected $country;
    
    /**
     * A collection of landmarks at this address.
     *
     * @var Collection
     * @OneToMany(
     *     targetEntity="API\Models\Entity\Location\Landmark",
     *     mappedBy="address"
     * )
     */
    protected $landmarks;
    
    // Constructor
    // ------------------------------------------------------------------
    
    /**
     * Address constructor.
     */
    public function __construct()
    {
        // Set collections
        $this->landmarks = new ArrayCollection();
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
     * Retrieves the ZIP code.
     *
     * @return string
     */
    public function getZip(): string
    {
        return $this->zip;
    }
    
    /**
     * Retrieves the address type.
     *
     * @return AddressType
     */
    public function getAddressType(): AddressType
    {
        return $this->address_type;
    }
    
    /**
     * Retrieves the district.
     *
     * @return District
     */
    public function getDistrict(): District
    {
        return $this->district;
    }
    
    /**
     * Retrieves the city.
     *
     * @return City
     */
    public function getCity(): City
    {
        return $this->city;
    }
    
    /**
     * Retrieves the state.
     *
     * @return State
     */
    public function getState(): State
    {
        return $this->state;
    }
    
    /**
     * Retrieves the country.
     *
     * @return Country
     */
    public function getCountry(): Country
    {
        return $this->country;
    }
    
    /**
     * Retrieves a collection of landmarks at this address.
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
     * Sets the ZIP code.
     *
     * @param string $zip
     * @return $this
     */
    public function setZip(string $zip)
    {
        $this->zip = $zip;
        return $this;
    }
    
    // Relationship managers
    // ------------------------------------------------------------------
    
    /**
     * Assigns an address type to this address.
     *
     * @param AddressType $address_type
     * @return $this
     */
    public function setAddressType(AddressType $address_type)
    {
        $this->address_type = $address_type;
        return $this;
    }
    
    /**
     * Assigns this address to a district.
     *
     * @param District $district
     * @return $this
     */
    public function setDistrict(District $district)
    {
        $this->district = $district;
        return $this;
    }
    
    /**
     * Assigns this district to a city.
     *
     * @param City $city
     * @return $this
     */
    public function setCity(City $city)
    {
        $this->city = $city;
        return $this;
    }
    
    /**
     * Assigns this district to a state.
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
     * Assigns this district to a country.
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
     * Assigns a landmark to this address.
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
     * Removes a landmark from this address.
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
