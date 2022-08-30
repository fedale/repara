<?php

namespace App\Entity\Customer;

use App\Entity\Asset\Asset;
use App\Repository\Customer\CustomerLocationPlaceAssetRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * CustomerLocationPlaceAsset
 */
#[ORM\Table(name: 'customer_location_place_asset', uniqueConstraints: [new ORM\UniqueConstraint(name: 'code', columns: ['code'])], indexes: [new ORM\Index(name: 'active', columns: ['active']), new ORM\Index(name: 'installation_doc', columns: ['installation_doc']), new ORM\Index(name: 'created_on', columns: ['created_on']), new ORM\Index(name: 'door_id', columns: ['asset_id']), new ORM\Index(name: 'created_at', columns: ['created_at']), new ORM\Index(name: 'modified_on', columns: ['modified_on']), new ORM\Index(name: 'installer_agency', columns: ['installer_agency']), new ORM\Index(name: 'location_place_id', columns: ['location_place_id']), new ORM\Index(name: 'updated_at', columns: ['updated_at']), new ORM\Index(name: 'executor_agency', columns: ['executor_agency']), new ORM\Index(name: 'compliance_doc', columns: ['compliance_doc']), new ORM\Index(name: 'name', columns: ['name'])])]
#[ORM\Entity(repositoryClass: CustomerLocationPlaceAssetRepository::class)]
class CustomerLocationPlaceAsset
{
    use TimestampableEntity;
    
    #[ORM\Column(name: 'id', type: 'integer', nullable: false, options: ['unsigned' => true])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private $id;
    
    #[ORM\Column(name: 'name', type: 'string', length: 64, nullable: false)]
    private $name;
    
    #[ORM\Column(name: 'code', type: 'string', length: 64, nullable: false)]
    private $code;
    
    #[ORM\Column(name: 'active', type: 'boolean', nullable: false, options: ['default' => 1])]
    private $active = true;

    #[ORM\ManyToOne(targetEntity: CustomerLocationPlace::class, inversedBy: 'customerLocationPlaceAssets')]
    #[ORM\JoinColumn(name: 'customer_location_place_id', nullable: false)]
    private $customerLocationPlace;

    #[ORM\ManyToOne(targetEntity: Asset::class, inversedBy: 'customerLocationPlaceAssets')]
    #[ORM\JoinColumn(name: 'asset_id', nullable: false)]
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
    
    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function getCustomerLocationPlace(): ?CustomerLocationPlace
    {
        return $this->customerLocationPlace;
    }

    public function setCustomerLocationPlace(?CustomerLocationPlace $customerLocationPlace): self
    {
        $this->customerLocationPlace = $customerLocationPlace;

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
}