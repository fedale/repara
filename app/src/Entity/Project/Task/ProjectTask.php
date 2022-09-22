<?php

namespace App\Entity\Project\Task;

use App\Entity\Project\TaskTemplate\ProjectTaskItemTemplate;
use App\Entity\Project\Task\ProjectTaskMilestone;
use App\Entity\Project\TaskItem\ProjectTaskItem;
use App\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Customer\Customer;
use App\Entity\Customer\CustomerLocationPlaceAsset; 
use App\Entity\Project\Project;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use App\DBAL\Types\ProjectTaskStateType;
use App\DBAL\Types\ProjectTaskPriorityType;
use Fresh\DoctrineEnumBundle\Validator\Constraints\EnumType;

/**
 * ProjectTask
 */
#[ORM\Table(name: 'project_task', 
    indexes: [
        new ORM\Index(name: 'name', columns: ['name']), 
        new ORM\Index(name: 'active', columns: ['active']), 
        new ORM\Index(name: 'created_on', columns: ['created_at']), 
        new ORM\Index(name: 'type_id', columns: ['type_id']), 
        new ORM\Index(name: 'state', columns: ['state']), 
        new ORM\Index(name: 'visible', columns: ['visible']), 
        new ORM\Index(name: 'modified_on', columns: ['modified_at']), 
        new ORM\Index(name: 'priority', columns: ['priority']), 
        new ORM\Index(name: 'project_id', columns: ['project_id']), 
        new ORM\Index(name: 'project_task_ibfk_3', columns: ['customer_location_place_asset_id']), 
        new ORM\Index(name: 'stuff_type', columns: ['asset_type']), 
        new ORM\Index(name: 'created_by', columns: ['created_by']), 
        new ORM\Index(name: 'place_id', columns: ['customer_id'])
    ]
)]
#[ORM\Entity]
class ProjectTask
{
    use TimestampableEntity;

    #[ORM\Column(name: 'id', type: 'integer', nullable: false, options: ['unsigned' => true])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private $id;
    
    #[ORM\Column(name: 'name', type: 'string', length: 128, nullable: false)]
    private $name;
    
    #[ORM\Column(name: 'description', type: 'text', length: 65535, nullable: true, options: ['default' => null])]
    private $description = NULL;
    
    #[ORM\Column(name: 'state', type: 'ProjectTaskStateType', length: 32, nullable: false)]
    #[EnumType(entity: ProjectTaskStateType::class)]
    private string $state = ProjectTaskStateType::STATE_REQUESTED;
    
    #[ORM\Column(name: 'asset_type', type: 'string', length: 8, nullable: false, options: ['default' => "'N/A'", 'comment' => 'Update with assetType value'])]
    private $assetType = 'N/A';
    
    #[ORM\Column(name: 'priority', type: 'ProjectTaskPriorityType', length: 32, nullable: false)]
    #[EnumType(entity: ProjectTaskPriorityType::class)]
    private string $priority = ProjectTaskPriorityType::PRIORITY_NORMAL;

    #[ORM\Column()]
    private bool $active = true;
    
    #[ORM\Column(name: 'visible', type: 'boolean', nullable: false, options: ['default' => 1])]
    private $visible = true;
    
    #[ORM\Column(name: 'finished_at', type: 'datetime', nullable: true)]
    private $finishedAt = NULL;

    #[ORM\ManyToOne(targetEntity: Customer::class)]
    #[ORM\JoinColumn(name: 'customer_id', referencedColumnName: 'id')]
    private $customer;

    #[ORM\ManyToOne(targetEntity: CustomerLocationPlaceAsset::class)]
    #[ORM\JoinColumn(name: 'customer_location_place_asset_id', referencedColumnName: 'id')]
    private $customerLocationPlaceAsset;

    #[ORM\ManyToOne(targetEntity: Project::class)]
    #[ORM\JoinColumn(name: 'project_id', referencedColumnName: 'id')]
    private $project;
    
    #[ORM\ManyToOne(targetEntity: ProjectTaskType::class)]
    #[ORM\JoinColumn(name: 'type_id', referencedColumnName: 'id')]
    private $type;

    #[ORM\ManyToMany(targetEntity: ProjectTaskTag::class, inversedBy: 'projectTasks')]
    #[ORM\JoinTable(name:'project_task_tag_assigned')]
    private $tags;

    #[ORM\OneToMany(mappedBy: 'projectTask', targetEntity: ProjectTaskMilestone::class)]
    private $projectTaskMilestones;

    #[ORM\OneToMany(mappedBy: 'projectTask', targetEntity: ProjectTaskItem::class)]
    private $projectTaskItems;

    #[ORM\OneToMany(mappedBy: 'projectTask', targetEntity: ProjectTaskActivity::class)]
    private $activities;
    
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'projectTasks')]
    #[ORM\JoinTable('project_task_user_assigned')]
    private Collection $projectTaskUserAssigneds;
    
    private $datetimeRange;

    
    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->activities = new ArrayCollection();
        $this->projectTaskUserAssigneds = new ArrayCollection();
        $this->projectTaskMilestones = new ArrayCollection();
        $this->projectTaskItems = new ArrayCollection();
        $this->userAssigneds = new ArrayCollection();
        $this->projectTaskItemTemplates = new ArrayCollection();
    }

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
    
    public function getDescription(): ?string
    {
        return $this->description;
    }
    
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
    
    public function getState(): ?string
    {
        return $this->state;
    }
    
    public function setState(string $state): self
    {
        $this->state = $state;

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
    
    public function getPriority(): ?string
    {
        return $this->priority;
    }
    
    public function setPriority(string $priority): self
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
    
    public function getCustomerLocationPlaceAsset(): ?CustomerLocationPlaceAsset
    {
        return $this->customerLocationPlaceAsset;
    }
    
    public function setCustomerLocationPlaceAsset(?CustomerLocationPlaceAsset $customerLocationPlaceAsset): self
    {
        $this->customerLocationPlaceAsset = $customerLocationPlaceAsset;

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

    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(ProjectTaskTag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(ProjectTaskTag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }
    
    /**
     * @return Collection<int, ProjectTaskMilestone>
     */
    public function getProjectTaskMilestones(): Collection
    {
        return $this->projectTaskMilestones;
    }

    public function addProjectTaskMilestone(ProjectTaskMilestone $projectTaskMilestone): self
    {
        if (!$this->projectTaskMilestones->contains($projectTaskMilestone)) {
            $this->projectTaskMilestones[] = $projectTaskMilestone;
            $projectTaskMilestone->setProjectTask($this);
        }

        return $this;
    }

    public function removeProjectTaskMilestone(ProjectTaskMilestone $projectTaskMilestone): self
    {
        if ($this->projectTaskMilestones->removeElement($projectTaskMilestone)) {
            // set the owning side to null (unless already changed)
            if ($projectTaskMilestone->getProjectTask() === $this) {
                $projectTaskMilestone->setProjectTask(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProjectTaskItem>
     */
    public function getProjectTaskItems(): Collection
    {
        return $this->projectTaskItems;
    }

    public function addProjectTaskItem(ProjectTaskItem $projectTaskItem): self
    {
        if (!$this->projectTaskItems->contains($projectTaskItem)) {
            $this->projectTaskItems[] = $projectTaskItem;
            $projectTaskItem->setProjectTask($this);
        }

        return $this;
    }

    public function removeProjectTaskItem(ProjectTaskItem $projectTaskItem): self
    {
        if ($this->projectTaskItems->removeElement($projectTaskItem)) {
            // set the owning side to null (unless already changed)
            if ($projectTaskItem->getProjectTask() === $this) {
                $projectTaskItem->setProjectTask(null);
            }
        }

        return $this;
    }

    /**
     * Get the value of datetimeRange
     */ 
    public function getDatetimeRange()
    {
        return $this->datetimeRange;
    }

    /**
     * Set the value of datetimeRange
     *
     * @return  self
     */ 
    public function setDatetimeRange($datetimeRange)
    {
        $this->datetimeRange = $datetimeRange;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getProjectTaskUserAssigneds(): Collection
    {
        return $this->projectTaskUserAssigneds;
    }

    public function addProjectTaskUserAssigned(User $projectTaskUserAssigned): self
    {
        if (!$this->projectTaskUserAssigneds->contains($projectTaskUserAssigned)) {
            $this->projectTaskUserAssigneds[] = $projectTaskUserAssigned;
        }

        return $this;
    }

    public function removeProjectTaskUserAssigned(User $projectTaskUserAssigned): self
    {
        $this->projectTaskUserAssigneds->removeElement($projectTaskUserAssigned);

        return $this;
    }

    public function getActivities(): Collection
    {
        return $this->activities;
    }

    public function addActivity(ProjectTaskActivity $activity): self
    {
        if (!$this->activities->contains($activity)) {
            $this->activities[] = $activity;
        }

        return $this;
    }

    public function removeActivity(ProjectTaskTag $activity): self
    {
        $this->activities->removeElement($activity);

        return $this;
    }
}