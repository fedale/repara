<?php

namespace App\Entity\Project\TaskItem;

use App\Entity\Project\Task\ProjectTask;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Table(name: 'project_task_item', indexes: [new ORM\Index(name: 'name', columns: ['name']), new ORM\Index(name: 'updated_at', columns: ['updated_at']), new ORM\Index(name: 'value', columns: ['value']), new ORM\Index(name: 'datetime_start', columns: ['datetime_start']), new ORM\Index(name: 'difficulty', columns: ['difficulty']), new ORM\Index(name: 'active', columns: ['active']), new ORM\Index(name: 'datetime_end', columns: ['datetime_end']), new ORM\Index(name: 'created_at', columns: ['created_at']), new ORM\Index(name: 'project_task_id', columns: ['project_task_id'])])]
#[ORM\Entity]
class ProjectTaskItem
{
    use TimestampableEntity;

    #[ORM\Column(name: 'id', type: 'integer', nullable: false, options: ['unsigned' => true])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private $id;
    
    #[ORM\Column(name: 'name', type: 'string', length: 255, nullable: false)]
    private $name;
    
    #[ORM\Column(name: 'description', type: 'text', length: 65535, nullable: true, options: ['default' => null])]
    private $description = NULL;
    
    #[ORM\Column(name: 'difficulty', type: 'boolean', nullable: false)]
    private $difficulty = 0;
    
    #[ORM\Column(name: 'value', type: 'string', length: 1, nullable: true, options: ['default' => null, 'fixed' => true])]
    private $value = NULL;
    
    #[ORM\Column(name: 'datetime_start', type: 'datetime', nullable: true, options: ['default' => null])]
    private $datetimeStart = NULL;
    
    #[ORM\Column(name: 'datetime_end', type: 'datetime', nullable: true, options: ['default' => null])]
    private $datetimeEnd = NULL;
    
    #[ORM\Column()]
    private bool $active = true;

    #[ORM\ManyToOne(targetEntity: ProjectTask::class, inversedBy: 'projectTaskItems')]
    #[ORM\JoinColumn(nullable: false)]
    private $projectTask;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDifficulty(): ?bool
    {
        return $this->difficulty;
    }

    public function setDifficulty(bool $difficulty): self
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): self
    {
        $this->value = $value;

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

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

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
