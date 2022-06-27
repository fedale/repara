<?php

namespace App\Entity\Customer;

use Doctrine\ORM\Mapping as ORM;

/**
 * CustomerPlaceAsset
 */
#[ORM\Table(name: 'customer_place_asset', uniqueConstraints: [new ORM\UniqueConstraint(name: 'code', columns: ['code'])], indexes: [new ORM\Index(name: 'active', columns: ['active']), new ORM\Index(name: 'installation_doc', columns: ['installation_doc']), new ORM\Index(name: 'created_on', columns: ['created_on']), new ORM\Index(name: 'door_id', columns: ['asset_id']), new ORM\Index(name: 'created_at', columns: ['created_at']), new ORM\Index(name: 'modified_on', columns: ['modified_on']), new ORM\Index(name: 'installer_agency', columns: ['installer_agency']), new ORM\Index(name: 'location_place_id', columns: ['location_place_id']), new ORM\Index(name: 'updated_at', columns: ['updated_at']), new ORM\Index(name: 'executor_agency', columns: ['executor_agency']), new ORM\Index(name: 'compliance_doc', columns: ['compliance_doc']), new ORM\Index(name: 'name', columns: ['name'])])]
#[ORM\Entity]
class CustomerPlaceAsset
{
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
     * @var \DateTime|null
     */
    #[ORM\Column(name: 'created_on', type: 'date', nullable: true, options: ['default' => null, 'comment' => 'data_installazione'])]
    private $createdOn = 'NULL';
    /**
     * @var string|null
     */
    #[ORM\Column(name: 'installer_agency', type: 'string', length: 128, nullable: true, options: ['default' => null, 'comment' => 'ditta installatrice'])]
    private $installerAgency = 'NULL';
    /**
     * @var string|null
     */
    #[ORM\Column(name: 'compliance_doc', type: 'string', length: 255, nullable: true, options: ['default' => null, 'comment' => 'dichiarazione_conformita'])]
    private $complianceDoc = 'NULL';
    /**
     * @var string|null
     */
    #[ORM\Column(name: 'installation_doc', type: 'string', length: 255, nullable: true, options: ['default' => null, 'comment' => 'dichiarazione_corretta_posa_in_opera'])]
    private $installationDoc = 'NULL';
    /**
     * @var \DateTime|null
     */
    #[ORM\Column(name: 'modified_on', type: 'date', nullable: true, options: ['default' => null, 'comment' => 'data_modifica'])]
    private $modifiedOn = 'NULL';
    /**
     * @var string|null
     */
    #[ORM\Column(name: 'executor_agency', type: 'string', length: 128, nullable: true, options: ['default' => null, 'comment' => 'ditta_esecutrice'])]
    private $executorAgency = 'NULL';
    /**
     * @var bool
     */
    #[ORM\Column(name: 'active', type: 'boolean', nullable: false, options: ['default' => 1])]
    private $active = true;
    /**
     * @var \DateTime
     */
    #[ORM\Column(name: 'created_at', type: 'datetime', nullable: false, options: ['default' => 'current_timestamp()'])]
    private $createdAt = 'current_timestamp()';
    /**
     * @var \DateTime
     */
    #[ORM\Column(name: 'updated_at', type: 'datetime', nullable: false, options: ['default' => 'current_timestamp()'])]
    private $updatedAt = 'current_timestamp()';
    /**
     * @var \DateTime|null
     */
    #[ORM\Column(name: 'deleted_at', type: 'datetime', nullable: true, options: ['default' => null])]
    private $deletedAt = 'NULL';
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
    public function getCreatedOn(): ?\DateTimeInterface
    {
        return $this->createdOn;
    }
    public function setCreatedOn(?\DateTimeInterface $createdOn): self
    {
        $this->createdOn = $createdOn;

        return $this;
    }
    public function getInstallerAgency(): ?string
    {
        return $this->installerAgency;
    }
    public function setInstallerAgency(?string $installerAgency): self
    {
        $this->installerAgency = $installerAgency;

        return $this;
    }
    public function getComplianceDoc(): ?string
    {
        return $this->complianceDoc;
    }
    public function setComplianceDoc(?string $complianceDoc): self
    {
        $this->complianceDoc = $complianceDoc;

        return $this;
    }
    public function getInstallationDoc(): ?string
    {
        return $this->installationDoc;
    }
    public function setInstallationDoc(?string $installationDoc): self
    {
        $this->installationDoc = $installationDoc;

        return $this;
    }
    public function getModifiedOn(): ?\DateTimeInterface
    {
        return $this->modifiedOn;
    }
    public function setModifiedOn(?\DateTimeInterface $modifiedOn): self
    {
        $this->modifiedOn = $modifiedOn;

        return $this;
    }
    public function getExecutorAgency(): ?string
    {
        return $this->executorAgency;
    }
    public function setExecutorAgency(?string $executorAgency): self
    {
        $this->executorAgency = $executorAgency;

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
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }
    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }
    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }
    public function isActive(): ?bool
    {
        return $this->active;
    }
}
