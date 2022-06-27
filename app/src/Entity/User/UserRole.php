<?php

namespace App\Entity\User;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * UserRole
 */
#[ORM\Table(name: 'user_role', uniqueConstraints: [new ORM\UniqueConstraint(name: 'code', columns: ['code'])], indexes: [new ORM\Index(name: 'name', columns: ['name'])])]
#[ORM\Entity]
class UserRole
{
    /**
     * @var int
     */
    #[ORM\Column(name: 'id', type: 'smallint', nullable: false, options: ['unsigned' => true])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private $id;
    /**
     * @var string
     */
    #[ORM\Column(name: 'code', type: 'string', length: 64, nullable: false)]
    private $code;
    /**
     * @var string
     */
    #[ORM\Column(name: 'name', type: 'string', length: 64, nullable: false)]
    private $name;
    /**
     * @var Collection
     */
    #[ORM\ManyToMany(targetEntity: 'User', mappedBy: 'roles')]
    private $users;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
    }
    public function __toString()
    {
        return $this->id;
    }
    public function getId(): ?int
    {
        return $this->id;
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
    public function getName(): ?string
    {
        return $this->name;
    }
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
    /**
     * @return Collection|User[]
     */
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
            $users->removeRole($this);
        }

        return $this;
    }
}
