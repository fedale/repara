<?php

namespace App\Entity\Asset;

use App\Entity\Customer\CustomerLocationPlaceAsset;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Asset
 */
#[ORM\Table(
    name: 'asset', 
    indexes: [
        new ORM\Index(name: 'name', columns: ['name']), 
        new ORM\Index(name: 'active', columns: ['active']), 
        new ORM\Index(name: 'model_id', columns: ['model_id']), 
        new ORM\Index(name: 'created_at', columns: ['created_at']), 
        new ORM\Index(name: 'updated_at', columns: ['updated_at'])
    ]
)]
#[ORM\Entity]
class Asset
{
    use TimestampableEntity;
    
    /**
     * @var int
     */
    #[ORM\Column(name: 'id', type: 'integer', nullable: false, options: ['unsigned' => true])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private $id;
    
    #[ORM\Column(name: 'name', type: 'string', length: 128, nullable: false)]
    private $name;

    #[Gedmo\Slug(fields:['name'])]
    #[ORM\Column(type: 'string', length: 128, unique: true)]
    private $slug;
    
    #[ORM\Column(name: 'active', type: 'boolean', nullable: false, options: ['default' => 1])]
    private $active = true;
    
    #[ORM\ManyToOne(targetEntity: AssetModel::class, fetch: 'EAGER')]
    #[ORM\JoinColumn(name: 'model_id', referencedColumnName: 'id')]
    private $model;

    #[ORM\OneToMany(targetEntity: CustomerLocationPlaceAsset::class, mappedBy: 'asset')]
    private $customerLocationPlaceAssets;

    public function __construct()
    {
        $this->customerLocationPlaceAssets = new ArrayCollection();
    }

    public function __toString(): string
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
    
    public function getModel(): ?AssetModel
    {
        return $this->model;
    }
    public function setModel(?AssetModel $model): self
    {
        $this->model = $model;

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

    /**
     * @return Collection<int, CustomerLocationPlaceAsset>
     */
    public function getCustomerLocationPlaceAssets(): Collection
    {
        return $this->customerLocationPlaceAssets;
    }

    public function addCustomerLocationPlaceAsset(CustomerLocationPlaceAsset $customerLocationPlaceAsset): self
    {
        if (!$this->customerLocationPlaceAssets->contains($customerLocationPlaceAsset)) {
            $this->customerLocationPlaceAssets[] = $customerLocationPlaceAsset;
            $customerLocationPlaceAsset->setAsset($this);
        }

        return $this;
    }

    public function removeCustomerLocationPlaceAsset(CustomerLocationPlaceAsset $customerLocationPlaceAsset): self
    {
        if ($this->customerLocationPlaceAssets->removeElement($customerLocationPlaceAsset)) {
            // set the owning side to null (unless already changed)
            if ($customerLocationPlaceAsset->getAsset() === $this) {
                $customerLocationPlaceAsset->setAsset(null);
            }
        }

        return $this;
    }
}
