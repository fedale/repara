<?php

namespace App\Entity\Customer;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * CustomerLocationPlaceAsset
 */
#[ORM\Table(name: 'customer_location_place_asset', uniqueConstraints: [new ORM\UniqueConstraint(name: 'code', columns: ['code'])], indexes: [new ORM\Index(name: 'active', columns: ['active']), new ORM\Index(name: 'installation_doc', columns: ['installation_doc']), new ORM\Index(name: 'created_on', columns: ['created_on']), new ORM\Index(name: 'door_id', columns: ['asset_id']), new ORM\Index(name: 'created_at', columns: ['created_at']), new ORM\Index(name: 'modified_on', columns: ['modified_on']), new ORM\Index(name: 'installer_agency', columns: ['installer_agency']), new ORM\Index(name: 'location_place_id', columns: ['location_place_id']), new ORM\Index(name: 'updated_at', columns: ['updated_at']), new ORM\Index(name: 'executor_agency', columns: ['executor_agency']), new ORM\Index(name: 'compliance_doc', columns: ['compliance_doc']), new ORM\Index(name: 'name', columns: ['name'])])]
#[ORM\Entity]
class CustomerLocationPlaceAsset
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
     * @var string
     */
    #[ORM\Column(name: 'code', type: 'string', length: 64, nullable: false)]
    private $code;
    
    /**
     * @var int
     */
    #[ORM\Column(name: 'location_place_id', type: 'integer', nullable: false, options: ['unsigned' => true])]
    private $locationPlaceId;
    
    /**
     * @var int
     */
    #[ORM\Column(name: 'asset_id', type: 'integer', nullable: false, options: ['unsigned' => true])]
    private $assetId;
    
    /**
     * @var bool
     */
    #[ORM\Column(name: 'active', type: 'boolean', nullable: false, options: ['default' => 1])]
    private $active = true;
    
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
    
    public function getLocationPlaceId(): ?int
    {
        return $this->locationPlaceId;
    }
    
    public function setLocationPlaceId(int $locationPlaceId): self
    {
        $this->locationPlaceId = $locationPlaceId;

        return $this;
    }
    
    public function getAssetId(): ?int
    {
        return $this->assetId;
    }
    
    public function setAssetId(int $assetId): self
    {
        $this->assetId = $assetId;

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
}
