<?php
namespace API\Models\Entity\Contents;

use API\Models\Entity\Users\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use HYKY\Core\BaseEntity;
use Slim\Collection;

/**
 * Services : API\Models\Entity\Contents\Content
 * ----------------------------------------------------------------------
 * Content entity.
 *
 * A content is a pretty standard type of entity, it can be either a post,
 * an article, a page or other things.
 *
 * @package     API\Models\Entity\Contents
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 *
 * @Entity
 * @Table(name="content")
 * @HasLifecycleCallbacks
 */
class Content extends BaseEntity
{
    // Properties
    // ------------------------------------------------------------------
    
    /**
     * Content title.
     *
     * @var string
     * @Column(type="string",length=128,nullable=false)
     */
    protected $title;
    
    /**
     * Content slug.
     *
     * @var string
     * @Column(type="string",length=128,nullable=false)
     */
    protected $slug;
    
    /**
     * Content leading text/excerpt.
     *
     * @var string
     * @Column(type="string",length=255,nullable=true)
     */
    protected $lead;
    
    /**
     * Content body.
     *
     * @var string
     * @Column(type="text",nullable=true)
     */
    protected $body;
    
    /**
     * Featured image file.
     *
     * @var string
     * @Column(type="string",length=128,nullable=true)
     */
    protected $image = null;
    
    /**
     * Featured image thumbnail file.
     *
     * @var string
     * @Column(type="string",length=128,nullable=true)
     */
    protected $thumb = null;
    
    /**
     * Featured status, mostly for blog posts, articles and news.
     *
     * @var bool
     * @Column(type="boolean",nullable=false)
     */
    protected $featured = false;
    
    /**
     * Publish status flag (0: Draft, 1: Published).
     *
     * @var int
     * @Column(type="integer", nullable=false)
     */
    protected $publish = 0;
    
    // Relationships
    // ------------------------------------------------------------------
    
    /**
     * Category assigned to this content.
     *
     * @var ContentCategory
     * @ManyToOne(
     *     targetEntity="API\Models\Entity\Contents\ContentCategory",
     *     inversedBy="contents"
     * )
     * @JoinColumn(name="category_id",referencedColumnName="id")
     */
    protected $category;
    
    /**
     * Collection of meta data assigned to this content.
     *
     * @var Collection
     * @OneToMany(
     *     targetEntity="API\Models\Entity\Contents\ContentMeta",
     *     mappedBy="content"
     * )
     */
    protected $meta_data;
    
    /**
     * Type assigned to this content.
     *
     * @var ContentType
     * @ManyToOne(
     *     targetEntity="API\Models\Entity\Contents\ContentType",
     *     inversedBy="contents"
     * )
     * @JoinColumn(name="type_id",referencedColumnName="id")
     */
    protected $type;
    
    /**
     * User assigned to this content, usually the author.
     *
     * @var User
     * @ManyToOne(
     *     targetEntity="API\Models\Entity\Users\User"
     * )
     * @JoinColumn(name="user_id",referencedColumnName="id",nullable=true)
     */
    protected $user;
    
    // Constructor
    // ------------------------------------------------------------------
    
    /**
     * Content constructor.
     */
    public function __construct()
    {
        // Set collections
        $this->meta_data = new ArrayCollection();
    }
    
    // Getters
    // ------------------------------------------------------------------
    
    /**
     * Retrieve the title.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
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
     * Retrieve the lead.
     *
     * @return string
     */
    public function getLead(): string
    {
        return $this->lead;
    }
    
    /**
     * Retrieve the body.
     *
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }
    
    /**
     * Retrieve the featured image.
     *
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }
    
    /**
     * Retrieve the featured image thumbnail.
     *
     * @return string
     */
    public function getThumb(): string
    {
        return $this->thumb;
    }
    
    /**
     * Retrieve the featured status.
     *
     * @return bool
     */
    public function getFeatured(): bool
    {
        return $this->featured;
    }
    
    /**
     * Retrieve the publish status.
     *
     * @return int
     */
    public function getPublish(): int
    {
        return $this->publish;
    }
    
    /**
     * Retrieve the category assigned to this content.
     *
     * @return ContentCategory
     */
    public function getCategory(): ContentCategory
    {
        return $this->category;
    }
    
    /**
     * Returns a collection of meta data associated with this content.
     *
     * @return Collection
     */
    public function getMetaData(): Collection
    {
        return $this->meta_data;
    }
    
    /**
     * Returns an associative array of meta data assigned to this content,
     * where the key is the slug and the value is the data.
     *
     * @return array
     */
    public function getMetaDataArray(): array
    {
        $meta = [];
        /** @var ContentMeta $meta_data */
        foreach ($this->meta_data as $meta_data) {
            $meta[$meta_data->getSlug()] = $meta_data->getValue();
        }
        return $meta;
    }
    
    /**
     * Retrieve the type assigned to this content.
     *
     * @return ContentType
     */
    public function getType(): ContentType
    {
        return $this->type;
    }
    
    /**
     * Retrieve the user associated with this content.
     *
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
    
    // Setters
    // ------------------------------------------------------------------
    
    /**
     * Sets the title.
     *
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
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
     * Sets the lead text.
     *
     * @param string $lead
     * @return $this
     */
    public function setLead(string $lead)
    {
        $this->lead = $lead;
        return $this;
    }
    
    /**
     * Sets the body.
     *
     * @param string $body
     * @return $this
     */
    public function setBody(string $body)
    {
        $this->body = $body;
        return $this;
    }
    
    /**
     * Sets the featured image.
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
     * Sets the featured image thumbnail.
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
     * Sets the featured status.
     *
     * @param bool $featured
     * @return $this
     */
    public function setFeatured(bool $featured)
    {
        $this->featured = $featured;
        return $this;
    }
    
    /**
     * Sets the publish status.
     *
     * @param int $publish
     * @return $this
     */
    public function setPublish(int $publish)
    {
        $this->publish = $publish;
        return $this;
    }
    
    /**
     * Assigns a category to this content.
     *
     * @param ContentCategory $category
     * @return $this
     */
    public function setCategory(ContentCategory $category)
    {
        $this->category = $category;
        return $this;
    }
    
    /**
     * Assigns a type to this content.
     *
     * @param ContentType $type
     * @return $this
     */
    public function setType(ContentType $type)
    {
        $this->type = $type;
        return $this;
    }
    
    /**
     * Assigns a user to this content.
     *
     * @param User $user
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }
    
    // Collection Managers
    // ------------------------------------------------------------------
    
    /**
     * Assigns meta data to this content.
     *
     * @param ContentMeta $meta
     * @return $this
     */
    public function addMetaData(ContentMeta $meta)
    {
        $this->meta_data[] = $meta;
        return $this;
    }
    
    /**
     * Removes the meta data associated with this content.
     *
     * @param string $meta_name
     * @return $this
     */
    public function removeMetaData(string $meta_name)
    {
        /** @var ContentMeta $meta_data */
        foreach ($this->meta_data as $meta_data) {
            if ($meta_data->getName() === $meta_name) {
                $this->meta_data->removeElement($meta_data);
            }
        }
        return $this;
    }
}
