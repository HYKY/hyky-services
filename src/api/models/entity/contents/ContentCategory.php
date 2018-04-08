<?php
namespace API\Models\Entity\Contents;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use HYKY\Core\BaseDateEntity;
use Slim\Collection;

/**
 * Services : API\Models\Entity\Contents\ContentCategory
 * ----------------------------------------------------------------------
 * Categories for contents. They're tied to both contents and types, so each
 * type has its own set of categories/taxonomies.
 *
 * @package     API\Models\Entity\Contents
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 *
 * @Entity
 * @Table(name="content_category")
 * @HasLifecycleCallbacks
 */
class ContentCategory extends BaseDateEntity
{
    // Properties
    // ------------------------------------------------------------------
    
    /**
     * Name.
     *
     * @var string
     * @Column(type="string",length=128,nullable=false)
     */
    protected $name;
    
    /**
     * Slug.
     *
     * @var string
     * @Column(type="string",length=128,nullable=false)
     */
    protected $slug;
    
    /**
     * Description.
     *
     * @var string
     * @Column(type="string",length=255,nullable=true)
     */
    protected $description;
    
    /**
     * Image.
     *
     * @var string
     * @Column(type="string",length=128,nullable=true)
     */
    protected $image;
    
    /**
     * Image thumbnail.
     *
     * @var string
     * @Column(type="string",length=128,nullable=true)
     */
    protected $thumb;
    
    // Relationships
    // ------------------------------------------------------------------
    
    /**
     * Collection of contents assigned to this category.
     *
     * @var Collection
     * @OneToMany(
     *     targetEntity="API\Models\Entity\Contents\Content",
     *     mappedBy="category"
     * )
     */
    protected $contents;
    
    /**
     * Type this category is assigned to.
     *
     * @var ContentType
     * @ManyToOne(
     *     targetEntity="API\Models\Entity\Contents\ContentType",
     *     inversedBy="categories"
     * )
     * @JoinColumn(name="type_id",referencedColumnName="id")
     */
    protected $type;
    
    // Constructor
    // ------------------------------------------------------------------
    
    /**
     * ContentCategory constructor.
     */
    public function __construct()
    {
        $this->contents = new ArrayCollection();
    }
    
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
     * Retrieve the description.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
    
    /**
     * Retrieve the image file.
     *
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }
    
    /**
     * Retrieve the image thumb file.
     *
     * @return string
     */
    public function getThumb(): string
    {
        return $this->thumb;
    }
    
    /**
     * Retrieve the collection of contents associated with this category.
     *
     * @return Collection
     */
    public function getContents(): Collection
    {
        return $this->contents;
    }
    
    /**
     * Retrieves an associative array of contents associated with this
     * category, where the key is the ID and value is the title.
     *
     * @return array
     */
    public function getContentsArray(): array
    {
        $contents = [];
        /** @var Content $content */
        foreach ($this->contents as $content) {
            $contents[$content->getId()] = $content->getTitle();
        }
        return $contents;
    }
    
    /**
     * Retrieve the type associated with this category.
     *
     * @return ContentType
     */
    public function getType(): ContentType
    {
        return $this->type;
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
     * Set the description.
     *
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
        return $this;
    }
    
    /**
     * Sets the image file.
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
     * Sets the image thumb file.
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
     * Assign this category to a type.
     *
     * @param ContentType $type
     * @return $this
     */
    public function setType(ContentType $type)
    {
        $this->type = $type;
        return $this;
    }
    
    // Collection Managers
    // ------------------------------------------------------------------
    
    /**
     * Assigns this category to a content.
     *
     * @param Content $content
     * @return $this
     */
    public function addContent(Content $content)
    {
        $this->contents[] = $content;
        return $this;
    }
    
    /**
     * Unassigns this category from a content.
     *
     * @param string $content_title
     * @return $this
     */
    public function removeContent(string $content_title)
    {
        /** @var Content $content */
        foreach ($this->contents as $content) {
            if ($content->getTitle() === $content_title) {
                $this->contents->removeElement($content);
            }
        }
        return $this;
    }
}
