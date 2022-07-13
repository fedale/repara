<?php

namespace App\Entity\Asset;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

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

    #[Gedmo\Slug(fields:['name'])]
    #[ORM\Column(type: 'string', length: 64, unique: true)]
    private $slug;

    #[ORM\Column(nullable: false)]
    private bool $active = true;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: AssetModel::class)]
    private $models;

    public function __construct()
    {
        $this->models = new ArrayCollection();
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

    /**
     * @return Collection<int, AssetModel>
     */
    public function getModels(): Collection
    {
        return $this->models;
    }

    public function addModel(AssetModel $model): self
    {
        if (!$this->models->contains($model)) {
            $this->models[] = $model;
            $model->setType($this);
        }

        return $this;
    }

    public function removeModel(AssetModel $model): self
    {
        if ($this->models->removeElement($model)) {
            // set the owning side to null (unless already changed)
            if ($model->getType() === $this) {
                $model->setType(null);
            }
        }

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
