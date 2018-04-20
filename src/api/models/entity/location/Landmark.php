<?php
namespace API\Models\Entity\Location;

use HYKY\Core\BaseProfileEntity;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

/**
 * Services : API\Models\Entity\Location\Landmark
 * ----------------------------------------------------------------------
 * Landmark entity, represents a single landmark or special point within
 * a location (address, city, state, district...).
 *
 * They're usually placed in collections of other entities.
 *
 * @package     API\Models\Entity\Location
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 *
 * @Entity
 * @Table(name="location_landmark")
 * @HasLifecycleCallbacks
 */
class Landmark extends BaseProfileEntity
{
    // Properties
    // ------------------------------------------------------------------
    
    /**
     * Landmark name.
     *
     * @var string
     * @Column(type="string",length=128,nullable=false)
     */
    protected $name;
    
    /**
     * Landmark latitude.
     *
     * @var float
     * @Column(type="float",nullable=false)
     */
    protected $latitude = 0.0;
    
    /**
     * Landmark longitude.
     *
     * @var float
     * @Column(type="float",nullable=false)
     */
    protected $longitude = 0.9;
    
    /**
     * Old database address value.
     *
     * @var string
     * @Column(type="string",length=255,nullable=true)
     */
    protected $old_address;
    
    /**
     * Old database ID.
     *
     * @var int
     * @Column(type="integer",nullable=true)
     */
    protected $old_id;
    
    // Relationships
    // ------------------------------------------------------------------
    
    /**
     * Address this landmark is located at.
     *
     * @var Address
     * @ManyToOne(
     *     targetEntity="API\Models\Entity\Location\Address",
     *     inversedBy="landmarks"
     * )
     * @JoinColumn(name="address_id",referencedColumnName="id")
     */
    protected $address;
    
    /**
     * City this landmark is located in.
     *
     * @var City
     * @ManyToOne(
     *     targetEntity="API\Models\Entity\Location\Address",
     *     inversedBy="landmarks"
     * )
     * @JoinColumn(name="city_id",referencedColumnName="id")
     */
    protected $city;
    
    // Constructor
    // ------------------------------------------------------------------
    
    /**
     * Landmark constructor.
     */
    public function __construct()
    {
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
     * Retrieves the latitude value.
     *
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }
    
    /**
     * Retrieves the longitude value.
     *
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }
    
    /**
     * Retrieves the old database address.
     *
     * @return string
     */
    public function getOldAddress(): string
    {
        return $this->old_address;
    }
    
    /**
     * Retrieves the old database ID.
     *
     * @return int
     */
    public function getOldId(): int
    {
        return $this->old_id;
    }
    
    /**
     * Retrieves the address this landmark is associated with.
     *
     * @return Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }
    
    /**
     * Retrieves the city this landmark is associated with.
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
    
    /**
     * Sets the latitude value.
     *
     * @param float $latitude
     * @return $this
     */
    public function setLatitude(float $latitude)
    {
        $this->latitude = $latitude;
        return $this;
    }
    
    /**
     * Sets the longitude value.
     *
     * @param float $longitude
     * @return $this
     */
    public function setLongitude(float $longitude)
    {
        $this->longitude = $longitude;
        return $this;
    }
    
    /**
     * Sets the old database address.
     *
     * @param string $old_address
     * @return $this
     */
    public function setOldAddress(string $old_address)
    {
        $this->old_address = $old_address;
        return $this;
    }
    
    /**
     * Sets the old database ID.
     *
     * @param int $old_id
     * @return $this
     */
    public function setOldId(int $old_id)
    {
        $this->old_id = $old_id;
        return $this;
    }
    
    // Relationship managers
    // ------------------------------------------------------------------
    
    /**
     * Assigns this landmark to an address.
     *
     * @param Address $address
     * @return $this
     */
    public function setAddress(Address $address)
    {
        $this->address = $address;
        return $this;
    }
    
    /**
     * Assigns this landmark to a city.
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
}
