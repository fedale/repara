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
    #[ORM\Column(name: 'name', type: 'string', length: 255, nullable: false)]
    private $name;
    
    /**
     * @var int
     */
    #[ORM\Column(name: 'sort', type: 'integer', nullable: false)]
    private $sort = 0;
    
    /**
     * @var bool
     */
    #[ORM\Column(name: 'active', type: 'boolean', nullable: false, options: ['default' => 1])]
    private $active = true;

    /**
     * @var ProjectTaskTemplate
     */
    #[ORM\ManyToOne(targetEntity: ProjectTaskTemplate::class)]
    #[ORM\JoinColumn(name: 'task_template_id', referencedColumnName: 'id')]
    private $taskTemplate;

    #[ORM\ManyToOne(targetEntity: ProjectTaskType::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProjectTask $taskType = null;

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

    public function getTaskType(): ?ProjectTask
    {
        return $this->taskType;
    }

    public function setTaskType(?ProjectTask $taskType): self
    {
        $this->taskType = $taskType;

        return $this;
    }
}