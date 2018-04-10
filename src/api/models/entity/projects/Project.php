<?php
namespace API\Models\Entity\Projects;

use API\Models\Entity\Users\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use HYKY\Core\BaseEntity;

/**
 * Services : API\Models\Entity\Projects\Project
 * ----------------------------------------------------------------------
 * Project entity, for all your workaholic pleasures and portfolio stuffing.
 *
 * @package     API\Models\Entity\Projects
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 *
 * @Entity
 * @Table(name="project")
 * @HasLifecycleCallbacks
 */
class Project extends BaseEntity
{
    // Properties
    // ------------------------------------------------------------------
    
    /**
     * Project name.
     *
     * @var string
     * @Column(type="string",length=128,nullable=false)
     */
    protected $name;
    
    /**
     * Project slug, must be unique.
     *
     * @var string
     * @Column(type="string",length=128,nullable=false)
     */
    protected $slug;
    
    /**
     * Project lead/short description.
     *
     * @var string
     * @Column(type="string",length=255,nullable=true)
     */
    protected $lead;
    
    /**
     * Project description.
     *
     * @var string
     * @Column(type="text",nullable=true)
     */
    protected $description;
    
    // Relationships
    // ------------------------------------------------------------------
    
    /**
     * Collection of media assigned to this project.
     *
     * @var Collection
     * @OneToMany(
     *     targetEntity="API\Models\Entity\Projects\ProjectMedia",
     *     mappedBy="project"
     * )
     */
    protected $media;
    
    /**
     * Collection of meta data assigned to this project.
     *
     * @var Collection
     * @OneToMany(
     *     targetEntity="API\Models\Entity\Projects\ProjectMeta",
     *     mappedBy="project"
     * )
     */
    protected $meta;
    
    /**
     * Owner of this project.
     *
     * @var User
     * @ManyToOne(
     *     targetEntity="API\Models\Entity\Users\User"
     * )
     */
    protected $owner;
    
    // Constructor
    // ------------------------------------------------------------------
    
    /**
     * Project constructor.
     */
    public function __construct()
    {
        // Set collections
        $this->media = new ArrayCollection();
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
     * Retrieve the leading text (short description).
     *
     * @return string
     */
    public function getLead(): string
    {
        return $this->lead;
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
     * Returns a collection of project media associated with this entity.
     *
     * @return Collection
     */
    public function getMedia(): Collection
    {
        return $this->media;
    }
    
    /**
     * Returns a collection of meta data associated with this project.
     *
     * @return Collection
     */
    public function getMeta(): Collection
    {
        return $this->meta;
    }
    
    /**
     * Returns an associative array of meta data for this project, where the
     * key is the slug.
     *
     * @return array
     */
    public function getMetaArray(): array
    {
        $metas = [];
        /** @var ProjectMeta $meta */
        foreach ($this->meta as $meta) {
            $metas[$meta->getSlug()] = $meta->getValue();
        }
        return $metas;
    }
    
    /**
     * Returns the user that owns this project.
     *
     * @return User
     */
    public function getOwner(): User
    {
        return $this->owner;
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
     * Set the lead text.
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
     * Assigns this project to a user.
     *
     * @param User $user
     * @return $this
     */
    public function setOwner(User $user)
    {
        $this->owner = $user;
        return $this;
    }
    
    // Collection Managers
    // ------------------------------------------------------------------
    
    /**
     * Assigns a media item to this project.
     *
     * @param ProjectMedia $media
     * @return $this
     */
    public function addMedia(ProjectMedia $media)
    {
        $this->media[] = $media;
        return $this;
    }
    
    /**
     * Removes a media item from this project.
     *
     * @param int $media_id
     * @return $this
     */
    public function removeMedia(int $media_id)
    {
        /** @var ProjectMedia $media */
        foreach ($this->media as $media) {
            if ($media->getId() === $media_id) {
                $this->media->removeElement($media);
            }
        }
        return $this;
    }
    
    /**
     * Assigns a meta data item to this project.
     *
     * @param ProjectMeta $meta
     * @return $this
     */
    public function addMeta(ProjectMeta $meta)
    {
        $this->meta[] = $meta;
        return $this;
    }
    
    /**
     * Removes a meta data from this project.
     *
     * @param int $meta_id
     * @return $this
     */
    public function removeMeta(int $meta_id)
    {
        /** @var ProjectMeta $meta*/
        foreach ($this->meta as $meta) {
            if ($meta->getId() === $meta_id) {
                $this->meta->removeElement($meta);
            }
        }
        return $this;
    }
}
