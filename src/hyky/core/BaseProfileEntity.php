<?php
namespace HYKY\Core;

use Doctrine\ORM\Mapping\Column;

/**
 * Services : HYKY\Core\BaseProfileEntity
 * ----------------------------------------------------------------------
 * Provides an extended version of `BaseEntity`, with some fields normally
 * used in profile-type entities.
 *
 * Besides the basic fields on `BaseEntity`, this entity also pre-declares:
 *
 * - Image (a file name)
 * - Thumb (must be derived from image)
 * - Short Description
 * - Description
 *
 * Since lots of entities ended up using these fields, to avoid repeated
 * declarations this base entity was created.
 *
 * All fields declared here are optional and nullable.
 *
 * @package     HYKY\Core
 * @author      HYKY team <we@hyky.games>
 * @since       0.0.1
 */
class BaseProfileEntity extends BaseEntity
{
    // Properties
    // ------------------------------------------------------------------
    
    /**
     * Image file name.
     *
     * This file must be stored in the entity's specific folder.
     *
     * @var string
     * @Column(type="string",length=128,nullable=true)
     */
    protected $image;
    
    /**
     * Image thumb file name.
     *
     * Usually saved in the same folder as `$image`, should have some kind
     * of suffix, to easily distinguish it from the parent image.
     *
     * @var string
     * @Column(type="string",length=128,nullable=true)
     */
    protected $thumb;
    
    /**
     * Short description for the entity.
     *
     * @var string
     * @Column(type="string",length=255,nullable=true)
     */
    protected $short_description;
    
    /**
     * Long description for the entity.
     *
     * @var string
     * @Column(type="text",nullable=true)
     */
    protected $description;
    
    // Getters
    // ------------------------------------------------------------------
    
    /**
     * Retrieves the image file name (without folder structure).
     *
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }
    
    /**
     * Retrieves the image thumb file name (without folder structure).
     *
     * @return string
     */
    public function getThumb(): string
    {
        return $this->thumb;
    }
    
    /**
     * Retrieves the short description.
     *
     * @return string
     */
    public function getShortDescription(): string
    {
        return $this->short_description;
    }
    
    /**
     * Retrieves the long description.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
    
    // Setters
    // ------------------------------------------------------------------
    
    /**
     * Sets the image file name.
     *
     * @param string $image
     * @return $this
     */
    public function setImage(string $image)
    {
        $this->image = $image;
        return $this;
    }
    
    /**
     * Sets the image thumbnail file name.
     *
     * @param string $thumb
     * @return $this
     */
    public function setThumb(string $thumb)
    {
        $this->thumb = $thumb;
        return $this;
    }
    
    /**
     * Sets the short description.
     *
     * @param string $short_description
     * @return $this
     */
    public function setShortDescription(string $short_description)
    {
        $this->short_description = $short_description;
        return $this;
    }
    
    /**
     * Sets the description.
     *
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
        return $this;
    }
}
