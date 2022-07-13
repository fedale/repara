<?php

namespace App\Entity\Asset;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * AssetModel
 */
#[ORM\Table(name: 'asset_model', indexes: [new ORM\Index(name: 'name', columns: ['name']), new ORM\Index(name: 'created_at', columns: ['created_at']), new ORM\Index(name: 'brand_id', columns: ['brand_id']), new ORM\Index(name: 'updated_at', columns: ['updated_at']), new ORM\Index(name: 'type_id', columns: ['type_id']), new ORM\Index(name: 'active', columns: ['active'])])]
#[ORM\Entity]
class AssetModel
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
    #[ORM\Column(name: 'name', type: 'string', length: 64, nullable: false)]
    private $name;

    #[Gedmo\Slug(fields:['name'])]
    #[ORM\Column(type: 'string', length: 64, unique: true)]
    private $slug;
    
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
     * @var AssetBrand
     */
    #[ORM\ManyToOne(targetEntity: 'AssetBrand', fetch: 'EAGER')]
    #[ORM\JoinColumn(name: 'brand_id', referencedColumnName: 'id')]
    private $brand;

    #[ORM\ManyToOne(targetEntity: AssetType::class, inversedBy: 'models')]
    #[ORM\JoinColumn(nullable: false)]
    private $type;

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

    public function getType(): ?AssetType
    {
        return $this->type;
    }

    public function setType(?AssetType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
