<?php

namespace App\Entity\Asset;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * AssetBrand
 */
#[ORM\Table(name: 'asset_brand', indexes: [new ORM\Index(name: 'name', columns: ['name']), new ORM\Index(name: 'active', columns: ['active']), new ORM\Index(name: 'created_at', columns: ['created_at']), new ORM\Index(name: 'updated_at', columns: ['updated_at'])])]
#[ORM\Entity]
class AssetBrand
{
    use TimestampableEntity;
     
    #[ORM\Column(name: 'id', type: 'integer', nullable: false, options: ['unsigned' => true])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private $id;
     
    #[ORM\Column(name: 'name', type: 'string', length: 128, nullable: false)]
    private $name;

    #[Gedmo\Slug(fields:['name'])]
    #[ORM\Column(name: 'slug', type: 'string', length: 128, unique: true)]
    private $slug;
    
    #[ORM\Column()]
    private bool $active = true;
    
    
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
    
    public function getActive(): ?bool
    {
        return $this->active;
    }
    
    public function setActive(bool $active): self
    {
        $this->active = $active;

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