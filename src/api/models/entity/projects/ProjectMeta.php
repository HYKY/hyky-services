<?php
namespace API\Models\Entity\Projects;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use HYKY\Core\BaseDateEntity;

/**
 * Services : API\Models\Entity\Projects\ProjectMeta
 * ----------------------------------------------------------------------
 * Handles project meta in an EAV model, in the same way `UserAttribute`
 * works for `User`, as to extend the length of the table in a "virtual" way.
 *
 * A project can have one or more meta data in a `Collection`.
 *
 * @package     API\Models\Entity\Projects
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 *
 * @Entity
 * @Table(name="project_meta")
 * @HasLifecycleCallbacks
 */
class ProjectMeta extends BaseDateEntity
{
    // Properties
    // ------------------------------------------------------------------
    
    /**
     * Meta data name.
     *
     * @var string
     * @Column(type="string",length=128,nullable=false)
     */
    protected $name;
    
    /**
     * Meta data slug.
     *
     * IMPORTANT:
     * Only lowercase letters and underscores!
     *
     * @var string
     * @Column(type="string",length=128,nullable=false)
     */
    protected $slug;
    
    /**
     * Meta data value.
     *
     * @var string
     * @Column(type="string",length=255,nullable=true)
     */
    protected $value;
    
    // Relationships
    // ------------------------------------------------------------------
    
    /**
     * Project this meta data is assigned to.
     *
     * @var Project
     * @ManyToOne(
     *     targetEntity="API\Models\Entity\Projects\Project",
     *     inversedBy="meta"
     * )
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
     * Retrieve the value.
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
    
    /**
     * Returns the project this data is assigned to.
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
     * Assigns this data to a project.
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
