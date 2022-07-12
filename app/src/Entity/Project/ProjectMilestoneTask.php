<?php

namespace App\Entity\Project;

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
     * @var int
     */
    #[ORM\Column(name: 'milestone_id', type: 'integer', nullable: false, options: ['unsigned' => true])]
    private $milestoneId;
    
    /**
     * @var int
     */
    #[ORM\Column(name: 'task_id', type: 'integer', nullable: false, options: ['unsigned' => true])]
    private $taskId;
    
    /**
     * @var bool
     */
    #[ORM\Column(name: 'active', type: 'boolean', nullable: false, options: ['default' => 1])]
    private $active = true;
    
    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getMilestoneId(): ?int
    {
        return $this->milestoneId;
    }
    
    public function setMilestoneId(int $milestoneId): self
    {
        $this->milestoneId = $milestoneId;

        return $this;
    }
    
    public function getTaskId(): ?int
    {
        return $this->taskId;
    }
    
    public function setTaskId(int $taskId): self
    {
        $this->taskId = $taskId;

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
}