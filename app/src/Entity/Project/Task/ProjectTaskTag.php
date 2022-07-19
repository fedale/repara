<?php

namespace App\Entity\Project\Task;

use App\Repository\Project\Task\ProjectTaskTagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectTaskTagRepository::class)]
#[ORM\Table(name: 'project_task_tag', indexes: [
    new ORM\Index(name: 'IDX_87F3F1931BA80DE3', columns: ['project_task_id']), 
    new ORM\Index(name: 'IDX_87F3F19349B41039', columns: ['project_task_tag_id'])
    ])]
class ProjectTaskTag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    // #[ORM\ManyToMany(targetEntity: ProjectTask::class, mappedBy: 'tags')]
    // private $tasks;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
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

    /**
     * @return Collection<int, ProjectTask>
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(ProjectTask $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
            $task->addTag($this);
        }

        return $this;
    }

    public function removeTask(ProjectTask $task): self
    {
        if ($this->tasks->removeElement($task)) {
            $task->removeTag($this);
        }

        return $this;
    }
}
