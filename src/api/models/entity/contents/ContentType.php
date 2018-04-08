<?php
namespace API\Models\Entity\Contents;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use HYKY\Core\BaseDateEntity;

/**
 * Services : API\Models\Entity\Contents\ContentType
 * ----------------------------------------------------------------------
 * Content type entity, to allow multiple content types to be used.
 *
 * Each content type has its own categories inventory.
 *
 * @package     API\Models\Entity\Contents
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 *
 * @Entity
 * @Table(name="content_type")
 * @HasLifecycleCallbacks
 */
class ContentType extends BaseDateEntity
{
    // Properties
    // ------------------------------------------------------------------
    
    /**
     * Type name.
     *
     * @var string
     * @Column(type="string",length=128,nullable=false)
     */
    protected $name;
    
    /**
     * Type slug.
     *
     * @var string
     * @Column(type="string",length=128,nullable=false)
     */
    protected $slug;
    
    /**
     * Type description.
     *
     * @var string
     * @Column(type="string",length=255,nullable=true)
     */
    protected $description;
    
    // Relationships
    // ------------------------------------------------------------------
    
    /**
     * Collection of categories assigned to this type.
     *
     * @var Collection
     * @OneToMany(
     *     targetEntity="API\Models\Entity\Contents\ContentCategory",
     *     mappedBy="type"
     * )
     */
    protected $categories;
    
    /**
     * Collection of contents assigned to this type.
     *
     * @var Collection
     * @OneToMany(
     *     targetEntity="API\Models\Entity\Contents\Content",
     *     mappedBy="type"
     * )
     */
    protected $contents;
    
    // Constructor
    // ------------------------------------------------------------------
    
    /**
     * ContentType constructor.
     */
    public function __construct()
    {
        // Set collections
        $this->categories = new ArrayCollection();
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
     * Retrieve the collection of categories assigned to this type.
     *
     * @return Collection
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }
    
    /**
     * Retrieves an associative array with the categories associated with this
     * type, where the key is the ID and value is the name.
     *
     * @return array
     */
    public function getCategoriesArray(): array
    {
        $categories = [];
        /** @var ContentCategory $category */
        foreach ($this->categories as $category) {
            $categories[$category->getId()] = $category->getName();
        }
        return $categories;
    }
    
    /**
     * Retrieve the collection of contents associated with this type.
     *
     * @return Collection
     */
    public function getContents(): Collection
    {
        return $this->contents;
    }
    
    /**
     * Retrieves an associative array with the contents associated with this
     * type, where the key is the ID and value is the title.
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
    
    // Collection Managers
    // ------------------------------------------------------------------
    
    /**
     * Assigns a content to this type.
     *
     * @param ContentCategory $category
     * @return $this
     */
    public function addCategory(ContentCategory $category)
    {
        $this->categories[] = $category;
        return $this;
    }
    
    /**
     * Unassigns a this category from a content.
     *
     * @param string $category_name
     * @return $this
     */
    public function removeCategory(string $category_name)
    {
        /** @var ContentCategory $category */
        foreach ($this->categories as $category) {
            if ($category->getName() === $category_name) {
                $this->categories->removeElement($category);
            }
        }
        return $this;
    }
    
    /**
     * Assigns a content to this type.
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
     * Unassigns a content to this type.
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
