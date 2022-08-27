<?php

namespace App\Entity\User;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Repository\User\UserRoleRepository;

/**
 * Role
 */
#[ORM\Table(name: 'user_role', 
    uniqueConstraints: [new ORM\UniqueConstraint(name: 'code', columns: ['code']), new ORM\UniqueConstraint(name: 'slug', columns: ['slug'])], 
    indexes: [new ORM\Index(name: 'name', columns: ['name'])]
)]
#[ORM\Entity(repositoryClass: UserRoleRepository::class)]
class UserRole
{
    /**
     * @var int
     */
    #[ORM\Column(name: 'id', type: 'smallint', nullable: false, options: ['unsigned' => true])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private $id;

    #[ORM\Column(name: 'slug', type: 'string', length: 64, nullable: false, unique: true)]
    #[Gedmo\Slug(fields: ['name'])]
    private $slug;

    #[ORM\Column(name: 'name', type: 'string', length: 64, nullable: false)]
    private $name;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'roles')]
    private $users;

    #[ORM\Column(type: 'string', length: 64, nullable: false, unique: true)]
    private $code;

    #[ORM\ManyToMany(targetEntity: self::class, mappedBy: 'children')]
    private Collection $parents;

    #[ORM\ManyToMany(targetEntity: self::class, inversedBy: 'parents')]
    #[ORM\JoinTable(
        name: 'user_role_hierarchy', 
        joinColumns: [new ORM\JoinColumn(name: 'parent', referencedColumnName: 'id')], 
        inverseJoinColumns: [new ORM\JoinColumn(name: 'child', referencedColumnName: 'id')]
    )]
    private Collection $children;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->parents = new ArrayCollection();
        $this->children = new ArrayCollection();
    }
    
    public function __toString()
    {
        return $this->code;
    }
    
    public function getId(): ?int
    {
        return $this->id;
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
    
    public function getName(): ?string
    {
        return $this->name;
    }
    
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
    
    public function getUsers(): Collection
    {
        return $this->users;
    }
    
    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addRole($this);
        }

        return $this;
    }
    
    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeRole($this);
        }

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

    /**
     * @return Collection<int, self>
     */
    public function getParents(): Collection
    {
        return $this->parents;
    }

    public function addParent(self $parent): self
    {
        if (!$this->parents->contains($parent)) {
            $this->parents->add($parent);
        }

        return $this;
    }

    public function removeParent(self $parent): self
    {
        $this->parents->removeElement($parent);

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(self $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children->add($child);
        }

        return $this;
    }

    public function removeChild(self $child): self
    {
        $this->children->removeElement($child);

        return $this;
    }
}