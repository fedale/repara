<?php

namespace App\Entity\Project;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProjectMilestone
 */
#[ORM\Table(name: 'project_milestone', indexes: [new ORM\Index(name: 'name', columns: ['name']), new ORM\Index(name: 'active', columns: ['active'])])]
#[ORM\Entity]
class ProjectMilestone
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
    #[ORM\Column(name: 'name', type: 'string', length: 32, nullable: false)]
    private $name;
    /**
     * @var \DateTime
     */
    #[ORM\Column(name: 'expiration_date', type: 'datetime', nullable: false)]
    private $expirationDate;
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
    public function getName(): ?string
    {
        return $this->name;
    }
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
    public function getExpirationDate(): ?\DateTimeInterface
    {
        return $this->expirationDate;
    }
    public function setExpirationDate(\DateTimeInterface $expirationDate): self
    {
        $this->expirationDate = $expirationDate;

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
