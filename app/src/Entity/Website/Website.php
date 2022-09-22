<?php

namespace App\Entity\Website;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * AdminWebsite
 */
#[ORM\Table(name: 'website', uniqueConstraints: [new ORM\UniqueConstraint(name: 'code', columns: ['code'])], indexes: [new ORM\Index(name: 'active', columns: ['active']), new ORM\Index(name: 'default_group_id', columns: ['default_group_id']), new ORM\Index(name: 'sort', columns: ['sort'])])]
#[ORM\Entity]
class Website
{
    use TimestampableEntity;
    
     
    #[ORM\Column(name: 'id', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private $id;
    
     
    #[ORM\Column(name: 'name', type: 'string', length: 32, nullable: false)]
    private $name;
    
    #[Gedmo\Slug(fields:["name"])]
    #[ORM\Column(name: 'code', type: 'string', length: 32, nullable: false, unique: true)]
    private $code;
    
     
    #[ORM\Column()]
    private bool $active = true;
    
     
    #[ORM\Column(name: 'default_group_id', type: 'integer', nullable: false)]
    private $defaultGroupId;
    
     
    #[ORM\Column(name: 'sort', type: 'smallint', nullable: false)]
    private $sort = 0;
    
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
    
    public function getCode(): ?string
    {
        return $this->code;
    }
    
    public function setCode(string $code): self
    {
        $this->code = $code;

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
    
    public function getDefaultGroupId(): ?int
    {
        return $this->defaultGroupId;
    }
    
    public function setDefaultGroupId(int $defaultGroupId): self
    {
        $this->defaultGroupId = $defaultGroupId;

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
}
