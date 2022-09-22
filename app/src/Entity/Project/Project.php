<?php

namespace App\Entity\Project;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Project
 */
#[ORM\Table(name: 'project', uniqueConstraints: [new ORM\UniqueConstraint(name: 'code', columns: ['code'])], indexes: [new ORM\Index(name: 'modified_at', columns: ['modified_at']), new ORM\Index(name: 'priority', columns: ['priority']), new ORM\Index(name: 'status', columns: ['status']), new ORM\Index(name: 'name', columns: ['name']), new ORM\Index(name: 'active', columns: ['active']), new ORM\Index(name: 'created_by', columns: ['created_by']), new ORM\Index(name: 'budget', columns: ['budget']), new ORM\Index(name: 'datetime_start', columns: ['datetime_start']), new ORM\Index(name: 'visible', columns: ['visible']), new ORM\Index(name: 'created_at', columns: ['created_at']), new ORM\Index(name: 'color', columns: ['color']), new ORM\Index(name: 'datetime_end', columns: ['datetime_end'])])]
#[ORM\Entity]
class Project
{
    use TimestampableEntity;

     
    #[ORM\Column(name: 'id', type: 'integer', nullable: false, options: ['unsigned' => true])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private $id;

     
    #[ORM\Column(name: 'code', type: 'string', length: 32, nullable: false)]
    private $code;

     
    #[ORM\Column(name: 'name', type: 'string', length: 128, nullable: false)]
    private $name;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'description', type: 'text', length: 65535, nullable: true, options: ['default' => null])]
    private $description = null;

    /**
     * @var \DateTime|null
     */
    #[ORM\Column(name: 'datetime_start', type: 'datetime', nullable: true, options: ['default' => null])]
    private $datetimeStart = null;

    /**
     * @var \DateTime|null
     */
    #[ORM\Column(name: 'datetime_end', type: 'datetime', nullable: true, options: ['default' => null])]
    private $datetimeEnd = null;

     
    #[ORM\Column(name: 'status', type: 'string', length: 32, nullable: false)]
    private $status = '0';

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'budget', type: 'decimal', precision: 15, scale: 2, nullable: true, options: ['default' => null])]
    private $budget = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'color', type: 'string', length: 6, nullable: true, options: ['default' => null, 'fixed' => true])]
    private $color = null;

    /**
     * @var bool
     */
    #[ORM\Column(name: 'priority', type: 'smallint', nullable: false)]
    private $priority = 0;

    /**
     * @var bool
     */
    #[ORM\Column()]
    private bool $active = true;

    /**
     * @var bool
     */
    #[ORM\Column(name: 'visible', type: 'boolean', nullable: false, options: ['default' => 1])]
    private $visible = true;

    /**
     * @var \DateTime|null
     */
    #[ORM\Column(name: 'finished_at', type: 'datetime', nullable: true, options: ['default' => null])]
    private $finishedAt = null;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: ProjectActivity::class)]
    private $activities;

    #[ORM\ManyToOne(targetEntity: ProjectType::class, inversedBy: 'projects')]
    #[ORM\JoinColumn(nullable: false)]
    private $type;

    public function __construct()
    {
        $this->activities = new ArrayCollection();
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getCode(): ?string
    {
        return $this->code;
    }
    
    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }
    
    public function getName(): ?string
    {
        return $this->name;
    }
    
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
    
    public function getDescription(): ?string
    {
        return $this->description;
    }
    
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
    
    public function getDatetimeStart(): ?\DateTimeInterface
    {
        return $this->datetimeStart;
    }
    
    public function setDatetimeStart(?\DateTimeInterface $datetimeStart): self
    {
        $this->datetimeStart = $datetimeStart;

        return $this;
    }
    
    public function getDatetimeEnd(): ?\DateTimeInterface
    {
        return $this->datetimeEnd;
    }
    
    public function setDatetimeEnd(?\DateTimeInterface $datetimeEnd): self
    {
        $this->datetimeEnd = $datetimeEnd;

        return $this;
    }
    
    public function getStatus(): ?string
    {
        return $this->status;
    }
    
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
    
    public function getBudget(): ?string
    {
        return $this->budget;
    }
    
    public function setBudget(?string $budget): self
    {
        $this->budget = $budget;

        return $this;
    }
    
    public function getColor(): ?string
    {
        return $this->color;
    }
    
    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }
    
    public function getPriority(): ?bool
    {
        return $this->priority;
    }
    
    public function setPriority(bool $priority): self
    {
        $this->priority = $priority;

        return $this;
    }
    
    public function getActive(): ?bool
    {
        return $this->active;
    }
    
    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }
    
    public function getVisible(): ?bool
    {
        return $this->visible;
    }
    
    public function setVisible(bool $visible): self
    {
        $this->visible = $visible;

        return $this;
    }
    
    public function getFinishedAt(): ?\DateTimeInterface
    {
        return $this->finishedAt;
    }
    
    public function setFinishedAt(?\DateTimeInterface $finishedAt): self
    {
        $this->finishedAt = $finishedAt;

        return $this;
    }

    /**
     * @return Collection<int, ProjectActivity>
     */
    public function getActivities(): Collection
    {
        return $this->activities;
    }

    public function addActivity(ProjectActivity $activity): self
    {
        if (!$this->activities->contains($activity)) {
            $this->activities[] = $activity;
            $activity->setProject($this);
        }

        return $this;
    }

    public function removeActivity(ProjectActivity $activity): self
    {
        if ($this->activities->removeElement($activity)) {
            // set the owning side to null (unless already changed)
            if ($activity->getProject() === $this) {
                $activity->setProject(null);
            }
        }

        return $this;
    }

    public function getType(): ?ProjectType
    {
        return $this->type;
    }

    public function setType(?ProjectType $type): self
    {
        $this->type = $type;

        return $this;
    }
}
