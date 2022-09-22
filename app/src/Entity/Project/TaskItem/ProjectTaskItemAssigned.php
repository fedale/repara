<?php

namespace App\Entity\Project\TaskItem;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\User\User;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * ProjectTaskItemAssigned
 */
#[ORM\Table(name: 'project_task_item_assigned', indexes: [new ORM\Index(name: 'user_id', columns: ['user_id']), new ORM\Index(name: 'updated_at', columns: ['updated_at']), new ORM\Index(name: 'task_item_id', columns: ['task_item_id']), new ORM\Index(name: 'active', columns: ['active']), new ORM\Index(name: 'created_at', columns: ['created_at'])])]
#[ORM\Entity]
class ProjectTaskItemAssigned
{
    use TimestampableEntity;

     
    #[ORM\Column(name: 'id', type: 'integer', nullable: false, options: ['unsigned' => true])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private $id;
    
    /**
     * @var bool
     */
    #[ORM\Column()]
    private bool $active = true;
    
    /**
     * @var User
     */
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private $user;
    
    /**
     * @var ProjectTaskItem
     */
    #[ORM\ManyToOne(targetEntity: 'ProjectTaskItem')]
    #[ORM\JoinColumn(name: 'project_task_item_id', referencedColumnName: 'id')]
    private $projectTaskItem;

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
    
    
    public function getUser(): ?User
    {
        return $this->user;
    }
    
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
    
    public function getProjectTaskItem(): ?ProjectTaskItem
    {
        return $this->projectTaskItem;
    }
    
    public function setProjectTaskItem(?ProjectTaskItem $projectTaskItem): self
    {
        $this->projectTaskItem = $projectTaskItem;

        return $this;
    }
}