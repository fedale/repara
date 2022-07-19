<?php

namespace App\Entity\Project;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * ProjectMilestone
 */
#[ORM\Table(name: 'project_milestone', indexes: [new ORM\Index(name: 'name', columns: ['name']), new ORM\Index(name: 'active', columns: ['active'])])]
#[ORM\Entity]
class ProjectMilestone
{
    use TimestampableEntity;

    /**
     * @var int
     */
    #[ORM\Column(name: 'id', type: 'integer', nullable: false, options: ['unsigned' => true])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private $id;
    
    /**
     * @var string
     */
    #[ORM\Column(name: 'name', type: 'string', length: 32, nullable: false)]
    private $name;
    
    /**
     * @var \DateTime
     */
    #[ORM\Column(name: 'expiration_date', type: 'datetime', nullable: false)]
    private $expirationDate;
    
    /**
     * @var bool
     */
    #[ORM\Column(name: 'active', type: 'boolean', nullable: false, options: ['default' => 1])]
    private $active = true;

    #[ORM\OneToMany(mappedBy: 'milestone', targetEntity: ProjectMilestoneTask::class)]
    private $projectMilestoneTasks;

    public function __construct()
    {
        $this->projectMilestoneTasks = new ArrayCollection();
    }
    
    public function getId(): ?int
    {
        return $this->id;
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
    
    public function getExpirationDate(): ?\DateTimeInterface
    {
        return $this->expirationDate;
    }
    
    public function setExpirationDate(\DateTimeInterface $expirationDate): self
    {
        $this->expirationDate = $expirationDate;

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

    /**
     * @return Collection<int, ProjectMilestoneTask>
     */
    public function getProjectMilestoneTasks(): Collection
    {
        return $this->projectMilestoneTasks;
    }

    public function addProjectMilestoneTask(ProjectMilestoneTask $projectMilestoneTask): self
    {
        if (!$this->projectMilestoneTasks->contains($projectMilestoneTask)) {
            $this->projectMilestoneTasks[] = $projectMilestoneTask;
            $projectMilestoneTask->setMilestone($this);
        }

        return $this;
    }

    public function removeProjectMilestoneTask(ProjectMilestoneTask $projectMilestoneTask): self
    {
        if ($this->projectMilestoneTasks->removeElement($projectMilestoneTask)) {
            // set the owning side to null (unless already changed)
            if ($projectMilestoneTask->getMilestone() === $this) {
                $projectMilestoneTask->setMilestone(null);
            }
        }

        return $this;
    }
}
