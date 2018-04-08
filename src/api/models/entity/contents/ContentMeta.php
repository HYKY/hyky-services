<?php
namespace API\Models\Entity\Contents;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use HYKY\Core\BaseDateEntity;

/**
 * Services : API\Models\Entity\Contents\ContentMeta
 * ----------------------------------------------------------------------
 * Content meta data entity, works the same way as `UserAttribute` to extend
 * the content's fields without making the table wider.
 *
 * @package     API\Models\Entity\Contents
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 *
 * @Entity
 * @Table(name="content_meta")
 * @HasLifecycleCallbacks
 */
class ContentMeta extends BaseDateEntity
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
     * Meta data type.
     *
     * @var string
     * @Column(type="string",nullable=false)
     */
    protected $meta_type = "field";
    
    /**
     * Value.
     *
     * @var string
     * @Column(type="string",length=2048,nullable=true)
     */
    protected $value;
    
    // Relationships
    // ------------------------------------------------------------------
    
    /**
     * Content this data is assigned to.
     *
     * @var Content
     * @ManyToOne(
     *     targetEntity="API\Models\Entity\Contents\Content",
     *     inversedBy="meta"
     * )
     * @JoinColumn(name="content_id",referencedColumnName="id")
     */
    protected $content;
    
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
     * Retrieve the meta data type.
     *
     * @return string
     */
    public function getMetaType(): string
    {
        return $this->meta_type;
    }
    
    /**
     * Retrieve the value.
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
    
    /**
     * Retrieve the content this type is assigned to.
     *
     * @return Content
     */
    public function getContent(): Content
    {
        return $this->content;
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
     * Sets the slug.
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
     * Sets the meta data type.
     *
     * @param string $meta_type
     * @return $this
     */
    public function setMetaType(string $meta_type)
    {
        $this->meta_type = $meta_type;
        return $this;
    }
    
    /**
     * Sets the value.
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
     * Assigns this data to a content.
     *
     * @param Content $content
     * @return $this
     */
    public function setContent(Content $content)
    {
        $this->content = $content;
        return $this;
    }
}
