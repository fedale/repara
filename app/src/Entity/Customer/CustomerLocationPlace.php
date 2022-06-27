<?php

namespace App\Entity\Customer;

use Doctrine\ORM\Mapping as ORM;

/**
 * CustomerLocationPlace
 */
#[ORM\Table(name: 'customer_location_place', indexes: [new ORM\Index(name: 'customer_id', columns: ['location_id']), new ORM\Index(name: 'updated_at', columns: ['updated_at']), new ORM\Index(name: 'name', columns: ['name']), new ORM\Index(name: 'active', columns: ['active']), new ORM\Index(name: 'created_at', columns: ['created_at'])])]
#[ORM\Entity]
class CustomerLocationPlace
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
    #[ORM\Column(name: 'name', type: 'string', length: 64, nullable: false)]
    private $name;
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
     * @var \CustomerLocation
     */
    #[ORM\ManyToOne(targetEntity: 'CustomerLocation')]
    #[ORM\JoinColumn(name: 'location_id', referencedColumnName: 'id')]
    private $location;
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
    public function getLocation(): ?CustomerLocation
    {
        return $this->location;
    }
    public function setLocation(?CustomerLocation $location): self
    {
        $this->location = $location;

        return $this;
    }
    public function isActive(): ?bool
    {
        return $this->active;
    }
}
