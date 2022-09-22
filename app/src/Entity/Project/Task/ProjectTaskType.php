<?php

namespace App\Entity\Project\Task;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProjectTaskType
 */
#[ORM\Table(name: 'project_task_type', indexes: [new ORM\Index(name: 'name', columns: ['name']), new ORM\Index(name: 'active', columns: ['active']), new ORM\Index(name: 'created_at', columns: ['created_at']), new ORM\Index(name: 'updated_at', columns: ['updated_at'])])]
#[ORM\Entity]
class ProjectTaskType
{
     
    #[ORM\Column(name: 'id', type: 'integer', nullable: false, options: ['unsigned' => true])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private $id;

     
    #[ORM\Column(name: 'name', type: 'string', length: 128, nullable: false)]
    private $name;

    /**
     * @var bool
     */
    #[ORM\Column()]
    private bool $active = true;

    
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
