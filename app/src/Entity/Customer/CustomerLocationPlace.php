<?php

namespace App\Entity\Customer;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * CustomerLocationPlace
 */
#[ORM\Table(name: 'customer_location_place', indexes: [new ORM\Index(name: 'customer_id', columns: ['location_id']), new ORM\Index(name: 'updated_at', columns: ['updated_at']), new ORM\Index(name: 'name', columns: ['name']), new ORM\Index(name: 'active', columns: ['active']), new ORM\Index(name: 'created_at', columns: ['created_at'])])]
#[ORM\Entity]
class CustomerLocationPlace
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
    /**
     * @var bool
     */
    #[ORM\Column(name: 'active', type: 'boolean', nullable: false, options: ['default' => 1])]
    private $active = true;
    /**
     * @var \DateTime
     */

    /**
     * @var CustomerLocation
     */
    #[ORM\ManyToOne(targetEntity: 'CustomerLocation')]
    #[ORM\JoinColumn(name: 'location_id', referencedColumnName: 'id')]
    private $location;

    #[ORM\OneToMany(mappedBy: 'customerLocationPlace', targetEntity: CustomerLocationPlaceAsset::class)]
    private $customerLocationPlaceAssets;

    public function __construct()
    {
        $this->customerLocationPlaceAssets = new ArrayCollection();
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
            $customerLocationPlaceAsset->setCustomerLocationPlace($this);
        }

        return $this;
    }

    public function removeCustomerLocationPlaceAsset(CustomerLocationPlaceAsset $customerLocationPlaceAsset): self
    {
        if ($this->customerLocationPlaceAssets->removeElement($customerLocationPlaceAsset)) {
            // set the owning side to null (unless already changed)
            if ($customerLocationPlaceAsset->getCustomerLocationPlace() === $this) {
                $customerLocationPlaceAsset->setCustomerLocationPlace(null);
            }
        }

        return $this;
    }
}
