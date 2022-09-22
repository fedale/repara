<?php

namespace App\Entity\Project\Task;

use App\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Table(name: 'project_task_user_assigned', 
    indexes: [
        new ORM\Index(name: 'user_id', columns: ['user_id']), 
        new ORM\Index(name: 'updated_at', columns: ['updated_at']), 
        new ORM\Index(name: 'project_task_id', columns: ['project_task_id']), 
        new ORM\Index(name: 'active', columns: ['active']), 
        new ORM\Index(name: 'created_at', columns: ['created_at'])
    ]
)]
#[ORM\Entity]
class ProjectTaskUserAssigned
{
    use TimestampableEntity;
    
    #[ORM\Column(name: 'id', type: 'integer', nullable: false, options: ['unsigned' => true])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private $id;
    
    #[ORM\Column()]
    private bool $active = true;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'projectTaskUserAssigneds')]
    #[ORM\JoinColumn(name: 'user_id', nullable: false)]
    private $users;

    // #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'projectTasks')]
    // #[ORM\JoinColumn(name: 'user_id', nullable: false)]
    // private $userAssigneds;

    // #[ORM\ManyToOne(targetEntity: ProjectTask::class, inversedBy: 'projectTaskUserAssigneds')]
    // #[ORM\JoinColumn(name: 'project_task_id', nullable: false)]
    // private $projectTasks;


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

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function getProjectTasks(): ?ProjectTask
    {
        return $this->projectTasks;
    }

    public function setProjectTasks(?ProjectTask $projectTasks): self
    {
        $this->projectTasks = $projectTasks;

        return $this;
    }
}