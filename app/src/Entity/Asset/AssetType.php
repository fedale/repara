<?php

namespace App\Entity\Asset;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Table('asset_type')]
#[ORM\Entity]
class AssetType
{
    use TimestampableEntity;

    #[ORM\Column]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    private ?int $id;

    #[ORM\Column(length: 64, nullable: false)]
    private string $name;

    #[ORM\Column(nullable: false)]
    private bool $active = true;
    

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
}
