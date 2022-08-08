<?php

namespace App\Entity\Project\TaskTemplate;

use App\Repository\Project\TaskTemplate\ProjectTaskTemplateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * ProjectTaskTemplate
 */
#[ORM\Table(name: 'project_task_template', indexes: [new ORM\Index(name: 'name', columns: ['name']), new ORM\Index(name: 'active', columns: ['active']), new ORM\Index(name: 'created_at', columns: ['created_at']), new ORM\Index(name: 'updated_at', columns: ['updated_at'])])]
#[ORM\Entity(repositoryClass: ProjectTaskTemplateRepository::class)]
class ProjectTaskTemplate
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
    #[ORM\Column(name: 'description', type: 'text', length: 16777215, nullable: true, options: ['default' => null])]
    private $description = null;
    
    /**
     * @var bool
     */
    #[ORM\Column(name: 'active', type: 'boolean', nullable: false, options: ['default' => 1])]
    private $active = true;

    #[ORM\OneToMany(mappedBy: 'taskTemplate', targetEntity: ProjectTaskItemTemplate::class, cascade: ['persist'])]
    private Collection $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
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
     * @return Collection<int, ProjectTaskItemTemplate>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(ProjectTaskItemTemplate $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setTaskTemplate($this);
        }

        return $this;
    }

    public function removeItem(ProjectTaskItemTemplate $item): self
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getTaskTemplate() === $this) {
                $item->setTaskTemplate(null);
            }
        }

        return $this;
    }
}
