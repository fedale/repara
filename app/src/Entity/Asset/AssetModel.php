<?php

namespace App\Entity\Asset;

use Doctrine\ORM\Mapping as ORM;

/**
 * AssetModel
 */
#[ORM\Table(name: 'asset_model', indexes: [new ORM\Index(name: 'name', columns: ['name']), new ORM\Index(name: 'created_at', columns: ['created_at']), new ORM\Index(name: 'brand_id', columns: ['brand_id']), new ORM\Index(name: 'updated_at', columns: ['updated_at']), new ORM\Index(name: 'type_id', columns: ['type_id']), new ORM\Index(name: 'active', columns: ['active'])])]
#[ORM\Entity]
class AssetModel
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
     * @var bool
     */
    #[ORM\Column(name: 'type_id', type: 'boolean', nullable: false)]
    private $typeId;
    /**
     * @var bool
     */
    #[ORM\Column(name: 'active', type: 'boolean', nullable: false, options: ['default' => 1])]
    private $active = true;
    /**
     * @var \DateTime
     */
    #[ORM\Column(name: 'created_at', type: 'datetime', nullable: false, options: ['default' => 'current_timestamp()'])]
    private $createdAt;
    /**
     * @var \DateTime
     */
    #[ORM\Column(name: 'updated_at', type: 'datetime', nullable: false, options: ['default' => 'current_timestamp()'])]
    private $updatedAt;
    /**
     * @var \DateTime|null
     */
    #[ORM\Column(name: 'deleted_at', type: 'datetime', nullable: true, options: ['default' => null])]
    private $deletedAt;
    /**
     * @var \AssetBrand
     */
    #[ORM\ManyToOne(targetEntity: 'AssetBrand', fetch: 'EAGER')]
    #[ORM\JoinColumn(name: 'brand_id', referencedColumnName: 'id')]
    private $brand;
    public function __toString(): string
    {
        return $this->getFullname();
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
    public function getTypeId(): ?bool
    {
        return $this->typeId;
    }
    public function setTypeId(bool $typeId): self
    {
        $this->typeId = $typeId;

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
    public function getBrand(): ?AssetBrand
    {
        return $this->brand;
    }
    public function setBrand(?AssetBrand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }
    public function getFullname(): ?string
    {
        return $this->name . ' ' . $this->getBrand()->getName();
    }
}
