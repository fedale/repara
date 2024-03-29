<?php

namespace App\Entity\Asset;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * AssetAttachment
 */
#[ORM\Table(name: 'asset_attachment', indexes: [new ORM\Index(name: 'stuff_id', columns: ['asset_id']), new ORM\Index(name: 'active', columns: ['active']), new ORM\Index(name: 'name', columns: ['name']), new ORM\Index(name: 'type', columns: ['type']), new ORM\Index(name: 'created_at', columns: ['created_at']), new ORM\Index(name: 'type_2', columns: ['type']), new ORM\Index(name: 'path', columns: ['path']), new ORM\Index(name: 'updated_at', columns: ['updated_at']), new ORM\Index(name: 'size', columns: ['size']), new ORM\Index(name: 'filename', columns: ['filename'])])]
#[ORM\Entity]
class AssetAttachment
{
    use TimestampableEntity;

    #[ORM\Column]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private $id;
    
     
    #[ORM\Column(name: 'name', type: 'string', length: 255, nullable: false)]
    private $name;

    #[Gedmo\Slug(fields:['name'])]
    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private $slug;
    
     
    #[ORM\Column(name: 'type', type: 'string', length: 32, nullable: false)]
    private $type;
     
    
     #[ORM\Column(name: 'size', type: 'integer', nullable: false, options: ['unsigned' => true])]
    private $size;
    
     
    #[ORM\Column(name: 'path', type: 'string', length: 128, nullable: false)]
    private $path;
    
     
    #[ORM\Column(name: 'filename', type: 'string', length: 128, nullable: false)]
    private $filename;
    
    #[ORM\Column()]
    private bool $active = true;
    
    /**
     * @var Asset
     */
    #[ORM\ManyToOne(targetEntity: 'Asset')]
    #[ORM\JoinColumn(name: 'asset_id', referencedColumnName: 'id')]
    private $asset;

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
    
    public function getType(): ?string
    {
        return $this->type;
    }
    
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
    
    public function getSize(): ?int
    {
        return $this->size;
    }
    
    public function setSize(int $size): self
    {
        $this->size = $size;

        return $this;
    }
    
    public function getPath(): ?string
    {
        return $this->path;
    }
    
    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }
    
    public function getFilename(): ?string
    {
        return $this->filename;
    }
    
    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

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
    
    public function getAsset(): ?Asset
    {
        return $this->asset;
    }
    
    public function setAsset(?Asset $asset): self
    {
        $this->asset = $asset;

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
