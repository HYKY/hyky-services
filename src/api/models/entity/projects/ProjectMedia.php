<?php
namespace API\Models\Entity\Projects;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use HYKY\Core\BaseDateEntity;

/**
 * Services : API\Models\Entity\Projects\ProjectMedia
 * ----------------------------------------------------------------------
 * Used to handle project media like images, music/sound, executables and
 * order files.
 *
 * It mostly stores values, so type definition, as well as file uploads MUST
 * MUST BE DONE EXTERNALLY.
 *
 * @package     API\Models\Entity\Projects
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 *
 * @Entity
 * @Table(name="project_media")
 * @HasLifecycleCallbacks
 */
class ProjectMedia extends BaseDateEntity
{
    // Properties
    // ------------------------------------------------------------------
    
    /**
     * Media name/label.
     *
     * @var string
     * @Column(type="string",length=128,nullable=false)
     */
    protected $name;
    
    /**
     * Media slug, derived from the name, must be unique.
     *
     * @var string
     * @Column(type="string",length=128,nullable=false)
     */
    protected $slug;
    
    /**
     * Media type.
     *
     * @var string
     * @Column(type="string",length=128,nullable=false)
     */
    protected $type;
    
    /**
     * Media value, usually the name of an uploaded file or URL.
     *
     * If the media is a file, assert that the file's name is unique, since
     * it will be uploaded to the default upload folder.
     *
     * @var string
     * @Column(type="string",length=255,nullable=false)
     */
    protected $value;
    
    /**
     * If the media is a URL or not, changes how this media is handled.
     *
     * @var bool
     * @Column(type="boolean",nullable=false)
     */
    protected $is_url = false;
    
    /**
     * Featured media flag, used by images (featured image from a gallery,
     * for example) or to handle the latest file (if the media is a zipped or
     * executable and it's versioned.
     *
     * @var bool
     * @Column(type="boolean",nullable=false)
     */
    protected $featured = false;
    
    /**
     * Media order, used when grouping media and it's required to have'em
     * sorted by a specific order.
     *
     * @var int
     * @Column(type="integer",nullable=false)
     */
    protected $item_order = 0;
    
    // Relationships
    // ------------------------------------------------------------------
    
    /**
     * Project entity this media is tied to.
     *
     * @var Project
     * @ManyToOne(
     *     targetEntity="API\Models\Entity\Projects\Project",
     *     inversedBy="media"
     * )
     * @JoinColumn(name="project_id",referencedColumnName="id")
     */
    protected $project;
    
    // Getters
    // ------------------------------------------------------------------
    
    /**
     * Retrieve the name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
     * Retrieve the slug.
     *
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }
    
    /**
     * Retrieve the media type (usually 'image', 'file', 'executable', 'audio',
     * 'video', etc.).
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
    
    /**
     * Retrieve the media value, either a URL or file name.
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
    
    /**
     * Retrieve the URL flag.
     *
     * @return bool
     */
    public function getIsUrl(): bool
    {
        return $this->is_url;
    }
    
    /**
     * Retrieve the featured media flag.
     *
     * @return bool
     */
    public function getFeatured(): bool
    {
        return $this->featured;
    }
    
    /**
     * Retrieve the item sorting order.
     *
     * @return int
     */
    public function getItemOrder(): int
    {
        return $this->item_order;
    }
    
    /**
     * Retrieve the project this media is assigned to.
     *
     * @return Project
     */
    public function getProject(): Project
    {
        return $this->project;
    }
    
    // Setters
    // ------------------------------------------------------------------
    
    /**
     * Set the name.
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
     * Set the slug.
     *
     * @param string $slug
     * @return $this
     */
    public function setSlug(string $slug)
    {
        $this->slug = $slug;
        return $this;
    }
    
    /**
     * Set the type.
     *
     * @param string $type
     * @return $this
     */
    public function setType(string $type)
    {
        $this->type = $type;
        return $this;
    }
    
    /**
     * Set the value.
     *
     * @param string $value
     * @return $this
     */
    public function setValue(string $value)
    {
        $this->value = $value;
        return $this;
    }
    
    /**
     * Set the URL flag, to indicate that this media is on an URL located
     * somewhere.
     *
     * @param string $is_url
     * @return $this
     */
    public function setIsUrl(string $is_url)
    {
        $this->is_url = $is_url;
        return $this;
    }
    
    /**
     * Set the featured status flag.
     *
     * @param string $featured
     * @return $this
     */
    public function setFeatured(string $featured)
    {
        $this->featured = $featured;
        return $this;
    }
    
    /**
     * Set the item order value.
     *
     * @param string $item_order
     * @return $this
     */
    public function setItemOrder(string $item_order)
    {
        $this->item_order = $item_order;
        return $this;
    }
    
    /**
     * Assigns this media item to a project.
     *
     * @param Project $project
     * @return $this
     */
    public function setProject(Project $project)
    {
        $this->project = $project;
        return $this;
    }
}
