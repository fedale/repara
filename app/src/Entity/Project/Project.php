<?php

namespace App\Entity\Project;

use Doctrine\ORM\Mapping as ORM;

/**
 * Project
 */
#[ORM\Table(name: 'project', uniqueConstraints: [new ORM\UniqueConstraint(name: 'code', columns: ['code'])], indexes: [new ORM\Index(name: 'modified_at', columns: ['modified_at']), new ORM\Index(name: 'priority', columns: ['priority']), new ORM\Index(name: 'status', columns: ['status']), new ORM\Index(name: 'name', columns: ['name']), new ORM\Index(name: 'active', columns: ['active']), new ORM\Index(name: 'created_by', columns: ['created_by']), new ORM\Index(name: 'budget', columns: ['budget']), new ORM\Index(name: 'datetime_start', columns: ['datetime_start']), new ORM\Index(name: 'visible', columns: ['visible']), new ORM\Index(name: 'created_at', columns: ['created_at']), new ORM\Index(name: 'color', columns: ['color']), new ORM\Index(name: 'datetime_end', columns: ['datetime_end'])])]
#[ORM\Entity]
class Project
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
    #[ORM\Column(name: 'code', type: 'string', length: 32, nullable: false)]
    private $code;
    /**
     * @var string
     */
    #[ORM\Column(name: 'name', type: 'string', length: 128, nullable: false)]
    private $name;
    /**
     * @var string|null
     */
    #[ORM\Column(name: 'description', type: 'text', length: 65535, nullable: true, options: ['default' => null])]
    private $description = 'NULL';
    /**
     * @var \DateTime|null
     */
    #[ORM\Column(name: 'datetime_start', type: 'datetime', nullable: true, options: ['default' => null])]
    private $datetimeStart = 'NULL';
    /**
     * @var \DateTime|null
     */
    #[ORM\Column(name: 'datetime_end', type: 'datetime', nullable: true, options: ['default' => null])]
    private $datetimeEnd = 'NULL';
    /**
     * @var string
     */
    #[ORM\Column(name: 'status', type: 'string', length: 32, nullable: false, options: ['default' => "'0'"])]
    private $status = '\'0\'';
    /**
     * @var string|null
     */
    #[ORM\Column(name: 'budget', type: 'decimal', precision: 15, scale: 2, nullable: true, options: ['default' => null])]
    private $budget = 'NULL';
    /**
     * @var string|null
     */
    #[ORM\Column(name: 'color', type: 'string', length: 6, nullable: true, options: ['default' => null, 'fixed' => true])]
    private $color = 'NULL';
    /**
     * @var bool
     */
    #[ORM\Column(name: 'priority', type: 'boolean', nullable: false)]
    private $priority = '0';
    /**
     * @var bool
     */
    #[ORM\Column(name: 'active', type: 'boolean', nullable: false, options: ['default' => 1])]
    private $active = true;
    /**
     * @var bool
     */
    #[ORM\Column(name: 'visible', type: 'boolean', nullable: false, options: ['default' => 1])]
    private $visible = true;
    /**
     * @var int
     */
    #[ORM\Column(name: 'created_by', type: 'integer', nullable: false, options: ['unsigned' => true])]
    private $createdBy;
    /**
     * @var \DateTime
     */
    #[ORM\Column(name: 'created_at', type: 'datetime', nullable: false, options: ['default' => 'current_timestamp()'])]
    private $createdAt = 'current_timestamp()';
    /**
     * @var \DateTime
     */
    #[ORM\Column(name: 'modified_at', type: 'datetime', nullable: false, options: ['default' => 'current_timestamp()'])]
    private $modifiedAt = 'current_timestamp()';
    /**
     * @var \DateTime|null
     */
    #[ORM\Column(name: 'deleted_at', type: 'datetime', nullable: true, options: ['default' => null])]
    private $deletedAt = 'NULL';
    /**
     * @var \DateTime|null
     */
    #[ORM\Column(name: 'finished_at', type: 'datetime', nullable: true, options: ['default' => null])]
    private $finishedAt = 'NULL';
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getCode(): ?string
    {
        return $this->code;
    }
    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
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
    public function getStatus(): ?string
    {
        return $this->status;
    }
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
    public function getBudget(): ?string
    {
        return $this->budget;
    }
    public function setBudget(?string $budget): self
    {
        $this->budget = $budget;

        return $this;
    }
    public function getColor(): ?string
    {
        return $this->color;
    }
    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }
    public function getPriority(): ?bool
    {
        return $this->priority;
    }
    public function setPriority(bool $priority): self
    {
        $this->priority = $priority;

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
    public function getVisible(): ?bool
    {
        return $this->visible;
    }
    public function setVisible(bool $visible): self
    {
        $this->visible = $visible;

        return $this;
    }
    public function getCreatedBy(): ?int
    {
        return $this->createdBy;
    }
    public function setCreatedBy(int $createdBy): self
    {
        $this->createdBy = $createdBy;

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
    public function getModifiedAt(): ?\DateTimeInterface
    {
        return $this->modifiedAt;
    }
    public function setModifiedAt(\DateTimeInterface $modifiedAt): self
    {
        $this->modifiedAt = $modifiedAt;

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
    public function getFinishedAt(): ?\DateTimeInterface
    {
        return $this->finishedAt;
    }
    public function setFinishedAt(?\DateTimeInterface $finishedAt): self
    {
        $this->finishedAt = $finishedAt;

        return $this;
    }
}
