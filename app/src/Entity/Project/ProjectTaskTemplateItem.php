<?php

namespace App\Entity\Project;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProjectTaskTemplateItem
 */
#[ORM\Table(name: 'project_task_template_item', indexes: [new ORM\Index(name: 'name', columns: ['name']), new ORM\Index(name: 'active', columns: ['active']), new ORM\Index(name: 'task_type_id', columns: ['task_id']), new ORM\Index(name: 'created_at', columns: ['created_at']), new ORM\Index(name: 'task_stuff_type', columns: ['task_type_id']), new ORM\Index(name: 'updated_at', columns: ['updated_at']), new ORM\Index(name: 'sort', columns: ['sort'])])]
#[ORM\Entity]
class ProjectTaskTemplateItem
{
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
    #[ORM\Column(name: 'task_type_id', type: 'integer', nullable: false, options: ['default' => 1, 'unsigned' => true])]
    private $taskTypeId = 1;
    /**
     * @var int
     */
    #[ORM\Column(name: 'sort', type: 'integer', nullable: false)]
    private $sort = '0';
    /**
     * @var bool
     */
    #[ORM\Column(name: 'active', type: 'boolean', nullable: false, options: ['default' => 1])]
    private $active = true;
    /**
     * @var \DateTime
     */
    #[ORM\Column(name: 'created_at', type: 'datetime', nullable: false, options: ['default' => 'current_timestamp()'])]
    private $createdAt = 'current_timestamp()';
    /**
     * @var \DateTime
     */
    #[ORM\Column(name: 'updated_at', type: 'datetime', nullable: false, options: ['default' => 'current_timestamp()'])]
    private $updatedAt = 'current_timestamp()';
    /**
     * @var \DateTime|null
     */
    #[ORM\Column(name: 'deleted_at', type: 'datetime', nullable: true, options: ['default' => null])]
    private $deletedAt = 'NULL';
    /**
     * @var \ProjectTaskTemplate
     */
    #[ORM\ManyToOne(targetEntity: 'ProjectTaskTemplate')]
    #[ORM\JoinColumn(name: 'task_id', referencedColumnName: 'id')]
    private $task;
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
    public function getTaskTypeId(): ?int
    {
        return $this->taskTypeId;
    }
    public function setTaskTypeId(int $taskTypeId): self
    {
        $this->taskTypeId = $taskTypeId;

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
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }
    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }
    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }
    public function getTask(): ?ProjectTaskTemplate
    {
        return $this->task;
    }
    public function setTask(?ProjectTaskTemplate $task): self
    {
        $this->task = $task;

        return $this;
    }
}
