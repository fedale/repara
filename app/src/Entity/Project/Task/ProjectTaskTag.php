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

    #[ORM\ManyToMany(targetEntity: ProjectTask::class, mappedBy: 'tags')]
    private $projectTasks;

    public function __construct()
    {
        $this->projectTasks = new ArrayCollection();
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
    public function getProjectTasks(): Collection
    {
        return $this->projectTasks;
    }

    public function addProjectTask(ProjectTask $projectTask): self
    {
        if (!$this->projectTasks->contains($projectTask)) {
            $this->projectTasks[] = $projectTask;
            $projectTask->addTag($this);
        }

        return $this;
    }

    public function removeProjectTask(ProjectTask $projectTask): self
    {
        if ($this->projectTasks->removeElement($projectTask)) {
            $projectTask->removeTag($this);
        }

        return $this;
    }
}