<?php

namespace App\Entity\Project;

use App\Entity\Project\Task\ProjectTask;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * ProjectMilestoneTask
 */
#[ORM\Table(name: 'project_milestone_task', indexes: [new ORM\Index(name: 'milestone_it', columns: ['milestone_id']), new ORM\Index(name: 'task_it', columns: ['task_id']), new ORM\Index(name: 'active', columns: ['active'])])]
#[ORM\Entity]
class ProjectMilestoneTask
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
     * @var bool
     */
    #[ORM\Column(name: 'active', type: 'boolean', nullable: false, options: ['default' => 1])]
    private $active = true;

    #[ORM\ManyToOne(targetEntity: ProjectMilestone::class, inversedBy: 'projectMilestoneTasks')]
    #[ORM\Column(name: 'milestone_id', type: 'integer', nullable: false, options: ['unsigned' => true])]
    #[ORM\JoinColumn(nullable: false)]
    private $milestone;

    #[ORM\ManyToOne(targetEntity: ProjectTask::class, inversedBy: 'projectMilestoneTasks')]
    #[ORM\Column(name: 'task_id', type: 'integer', nullable: false, options: ['unsigned' => true])]
    #[ORM\JoinColumn(nullable: false)]
    private $projectTask;
    
    public function getId(): ?int
    {
        return $this->id;
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

    public function getMilestone(): ?ProjectMilestone
    {
        return $this->milestone;
    }

    public function setMilestone(?ProjectMilestone $milestone): self
    {
        $this->milestone = $milestone;

        return $this;
    }

    public function getProjectTask(): ?ProjectTask
    {
        return $this->projectTask;
    }

    public function setProjectTask(?ProjectTask $projectTask): self
    {
        $this->projectTask = $projectTask;

        return $this;
    }
}