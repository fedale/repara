<?php

namespace App\Entity\Project\Task;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\User\User;
use App\Entity\Project\Task\ProjectTask;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * ProjectTaskAttachment
 */
#[ORM\Table(name: 'project_task_attachment', indexes: [new ORM\Index(name: 'stuff_id', columns: ['project_task_id']), new ORM\Index(name: 'active', columns: ['active']), new ORM\Index(name: 'size', columns: ['size']), new ORM\Index(name: 'path', columns: ['path']), new ORM\Index(name: 'created_at', columns: ['created_at']), new ORM\Index(name: 'type_3', columns: ['type']), new ORM\Index(name: 'filename', columns: ['filename']), new ORM\Index(name: 'updated_at', columns: ['updated_at']), new ORM\Index(name: 'user_id', columns: ['user_id']), new ORM\Index(name: 'name', columns: ['name'])])]
#[ORM\Entity]
class ProjectTaskAttachment
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
    #[ORM\Column(name: 'name', type: 'string', length: 255, nullable: false)]
    private $name;
    
    /**
     * @var string
     */
    #[ORM\Column(name: 'type', type: 'string', length: 32, nullable: false, options: ['default' => "'image'"])]
    private $type = 'image';
    
    /**
     * @var int
     */
    #[ORM\Column(name: 'size', type: 'integer', nullable: false, options: ['unsigned' => true])]
    private $size;
    
    /**
     * @var string
     */
    #[ORM\Column(name: 'path', type: 'string', length: 128, nullable: false)]
    private $path;
    
    /**
     * @var string
     */
    #[ORM\Column(name: 'filename', type: 'string', length: 128, nullable: false)]
    private $filename;
    
    /**
     * @var bool
     */
    #[ORM\Column(name: 'active', type: 'boolean', nullable: false, options: ['default' => 1])]
    private $active = true;

    /**
     * @var User
     */
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private $user;

    /**
     * @var ProjectTask
     */
    #[ORM\ManyToOne(targetEntity: ProjectTask::class)]
    #[ORM\JoinColumn(name: 'project_task_id', referencedColumnName: 'id')]
    private $projectTask;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getProjectTask(): ?ProjectTask
    {
        return $this->projectTask;
    }

    public function setProjectTask(?ProjectTask $projectTask): self
    {
        $this->projectTask = $projectTask;

        return $this;
    }
}
