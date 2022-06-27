<?php

namespace App\Entity\Project;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProjectTaskAssigned
 */
#[ORM\Table(name: 'project_task_assigned', indexes: [new ORM\Index(name: 'user_id', columns: ['user_id']), new ORM\Index(name: 'updated_at', columns: ['updated_at']), new ORM\Index(name: 'task_item_id', columns: ['task_id']), new ORM\Index(name: 'active', columns: ['active']), new ORM\Index(name: 'created_at', columns: ['created_at'])])]
#[ORM\Entity]
class ProjectTaskAssigned
{
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
    #[ORM\Column(name: 'user_id', type: 'integer', nullable: false, options: ['unsigned' => true])]
    private $userId;
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
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getUserId(): ?int
    {
        return $this->userId;
    }
    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

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
}
