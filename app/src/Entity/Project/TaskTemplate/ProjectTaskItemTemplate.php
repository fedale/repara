<?php

namespace App\Entity\Project\TaskTemplate;

use App\Entity\Project\Task\ProjectTask;
use App\Entity\Project\Task\ProjectTaskType;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * ProjectTaskItemTemplate
 */
#[ORM\Table(name: 'project_task_item_template', 
    indexes: [
        new ORM\Index(name: 'name', columns: ['name']), 
        new ORM\Index(name: 'active', columns: ['active']), 
        new ORM\Index(name: 'task_template_id', columns: ['task_template_id']), 
        new ORM\Index(name: 'created_at', columns: ['created_at']), 
        new ORM\Index(name: 'task_type_id', columns: ['task_type_id']), 
        new ORM\Index(name: 'updated_at', columns: ['updated_at']), 
        new ORM\Index(name: 'sort', columns: ['sort'])]
)]
#[ORM\Entity]
class ProjectTaskItemTemplate
{
    use TimestampableEntity;

     
    #[ORM\Column(name: 'id', type: 'integer', nullable: false, options: ['unsigned' => true])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private $id;
    
     
    #[ORM\Column(name: 'name', type: 'string', length: 255, nullable: false)]
    private $name;
    
     
    #[ORM\Column(name: 'sort', type: 'integer', nullable: false)]
    private $sort = 0;
    
    /**
     * @var bool
     */
    #[ORM\Column()]
    private bool $active = true;

    /**
     * @var ProjectTaskTemplate
     */
    #[ORM\ManyToOne(targetEntity: ProjectTaskTemplate::class, inversedBy: 'items')]
    #[ORM\JoinColumn(name: 'task_template_id', referencedColumnName: 'id', nullable: false)]
    private ?ProjectTaskTemplate $taskTemplate;

    #[ORM\ManyToOne(targetEntity: ProjectTaskType::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProjectTaskType $taskType = null;

    public function __toString()
    {
        return $this->name;
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

    public function getSort(): ?int
    {
        return $this->sort;
    }

    public function setSort(int $sort): self
    {
        $this->sort = $sort;

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
    public function getTaskTemplate(): ?ProjectTaskTemplate
    {
        return $this->taskTemplate;
    }

    public function setTaskTemplate(?ProjectTaskTemplate $taskTemplate): self
    {
        $this->taskTemplate = $taskTemplate;

        return $this;
    }

    public function getTaskType(): ?ProjectTaskType
    {
        return $this->taskType;
    }

    public function setTaskType(?ProjectTaskType $taskType): self
    {
        $this->taskType = $taskType;

        return $this;
    }
}