<?php

namespace App\Entity\Project;

use App\Entity\Project\Task\ProjectTaskMilestone;
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

     
    #[ORM\Column(name: 'id', type: 'integer', nullable: false, options: ['unsigned' => true])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private $id;
    
     
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
    #[ORM\Column()]
    private bool $active = true;

    // #[ORM\OneToMany(mappedBy: 'milestone', targetEntity: ProjectTaskMilestone::class)]
    // private $projectTaskMilestones;

    public function __construct()
    {
        $this->projectTaskMilestones = new ArrayCollection();
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
     * @return Collection<int, ProjectTaskMilestone>
     */
    public function getProjectTaskMilestones(): Collection
    {
        return $this->projectTasksMilestones;
    }

    public function addProjectTaskMilestone(ProjectTaskMilestone $projectTaskMilestone): self
    {
        if (!$this->projectTaskMilestones->contains($projectTaskMilestone)) {
            $this->projectTaskMilestones[] = $projectTaskMilestone;
            $projectTaskMilestone->setMilestone($this);
        }

        return $this;
    }

    public function removeProjectTaskMilestone(ProjectTaskMilestone $projectTaskMilestone): self
    {
        if ($this->projectTaskMilestones->removeElement($projectTaskMilestone)) {
            // set the owning side to null (unless already changed)
            if ($projectTaskMilestone->getMilestone() === $this) {
                $projectTaskMilestone->setMilestone(null);
            }
        }

        return $this;
    }
}