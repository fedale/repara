<?php

namespace App\Entity\Project\Task;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Customer\Customer;
use App\Entity\Customer\CustomerLocationPlaceAsset;
use App\Entity\Project\Project;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * ProjectTask
 */
#[ORM\Table(name: 'project_task', indexes: [new ORM\Index(name: 'name', columns: ['name']), new ORM\Index(name: 'active', columns: ['active']), new ORM\Index(name: 'created_on', columns: ['created_at']), new ORM\Index(name: 'type_id', columns: ['type_id']), new ORM\Index(name: 'status', columns: ['status']), new ORM\Index(name: 'visible', columns: ['visible']), new ORM\Index(name: 'modified_on', columns: ['modified_at']), new ORM\Index(name: 'priority', columns: ['priority']), new ORM\Index(name: 'project_id', columns: ['project_id']), new ORM\Index(name: 'project_task_ibfk_3', columns: ['customer_location_place_asset_id']), new ORM\Index(name: 'stuff_type', columns: ['asset_type']), new ORM\Index(name: 'created_by', columns: ['created_by']), new ORM\Index(name: 'place_id', columns: ['customer_id'])])]
#[ORM\Entity]
class ProjectTask
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
    #[ORM\Column(name: 'name', type: 'string', length: 128, nullable: false)]
    private $name;
    
    /**
     * @var string|null
     */
    #[ORM\Column(name: 'description', type: 'text', length: 65535, nullable: true, options: ['default' => null])]
    private $description = NULL;
    
    /**
     * @var string
     */
    #[ORM\Column(name: 'status', type: 'string', length: 32, nullable: false)]
    private $status;
    
    /**
     * @var string
     */
    #[ORM\Column(name: 'asset_type', type: 'string', length: 8, nullable: false, options: ['default' => "'N/A'", 'comment' => 'Update with assetType value'])]
    private $assetType = 'N/A';
    
    /**
     * @var int
     */
    #[ORM\Column(name: 'priority', type: 'smallint', nullable: false)]
    private $priority = 0;

    /**
     * @var bool
     */
    #[ORM\Column(name: 'active', type: 'boolean', nullable: false, options: ['default' => 1])]
    private $active = true;
    
    /**
     * @var bool
     */
    #[ORM\Column(name: 'visible', type: 'boolean', nullable: false, options: ['default' => 1])]
    private $visible = true;
    
    /**
     * @var int
     */
    #[ORM\Column(name: 'created_by', type: 'integer', nullable: false)]
    private $createdBy;

    /**
     * @var \DateTime|null
     */
    #[ORM\Column(name: 'finished_at', type: 'datetime', nullable: true)]
    private $finishedAt = NULL;

    /**
     * @var Customer
     */
    #[ORM\ManyToOne(targetEntity: Customer::class)]
    #[ORM\JoinColumn(name: 'customer_id', referencedColumnName: 'id')]
    private $customer;

    /**
     * @var CustomerLocationPlaceAsset
     */
    #[ORM\ManyToOne(targetEntity: CustomerLocationPlaceAsset::class)]
    #[ORM\JoinColumn(name: 'customer_location_place_asset_id', referencedColumnName: 'id')]
    private $customerPlaceAsset;

    /**
     * @var Project
     */
    #[ORM\ManyToOne(targetEntity: Project::class)]
    #[ORM\JoinColumn(name: 'project_id', referencedColumnName: 'id')]
    private $project;

    /**
     * @var ProjectTaskType
     */
    #[ORM\ManyToOne(targetEntity: ProjectTaskType::class)]
    #[ORM\JoinColumn(name: 'type_id', referencedColumnName: 'id')]
    private $type;

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
    
    public function getDescription(): ?string
    {
        return $this->description;
    }
    
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
    
    public function getStatus(): ?string
    {
        return $this->status;
    }
    
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
    
    public function getAssetType(): ?string
    {
        return $this->assetType;
    }
    
    public function setAssetType(string $assetType): self
    {
        $this->assetType = $assetType;

        return $this;
    }
    
    public function getPriority(): ?int
    {
        return $this->priority;
    }
    
    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

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
    
    public function getVisible(): ?bool
    {
        return $this->visible;
    }
    
    public function setVisible(bool $visible): self
    {
        $this->visible = $visible;

        return $this;
    }
    
    public function getCreatedBy(): ?int
    {
        return $this->createdBy;
    }
    
    public function setCreatedBy(int $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }
    
    public function getFinishedAt(): ?\DateTimeInterface
    {
        return $this->finishedAt;
    }
    
    public function setFinishedAt(?\DateTimeInterface $finishedAt): self
    {
        $this->finishedAt = $finishedAt;

        return $this;
    }
    
    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }
    
    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }
    
    public function getCustomerPlaceAsset(): ?CustomerPlaceAsset
    {
        return $this->customerPlaceAsset;
    }
    
    public function setCustomerPlaceAsset(?CustomerPlaceAsset $customerPlaceAsset): self
    {
        $this->customerPlaceAsset = $customerPlaceAsset;

        return $this;
    }
    
    public function getProject(): ?Project
    {
        return $this->project;
    }
    
    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }
    
    public function getType(): ?ProjectTaskType
    {
        return $this->type;
    }
    
    public function setType(?ProjectTaskType $type): self
    {
        $this->type = $type;

        return $this;
    }
}
