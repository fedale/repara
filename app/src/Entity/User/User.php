<?php

namespace App\Entity\User;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use App\Repository\User\UserRepository;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * User
 */
#[ORM\Table(name: 'user', uniqueConstraints: [new ORM\UniqueConstraint(name: 'user_unique_username', columns: ['username']), new ORM\UniqueConstraint(name: 'user_unique_email', columns: ['email'])], indexes: [new ORM\Index(name: 'type_id', columns: ['type_id']), new ORM\Index(name: 'active', columns: ['active'])])]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields:['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use TimestampableEntity;

    /**
     * @var int
     */
    #[ORM\Column(name: 'id', type: 'integer', nullable: false, options: ['unsigned' => true])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private $id;

    #[ORM\Column(length: 64, nullable: false, unique: true)]
    private string $code;
    
    /**
     * @var string
     */
    #[ORM\Column(name: 'username', type: 'string', length: 255, nullable: false, unique: true)]
    private string $username;

    /**
     * @var string
     */
    #[ORM\Column(name: 'email', type: 'string', length: 255, nullable: false, unique: true)]
    #[Assert\Email]
    private string $email;

    /**
     * @var string
     */
    #[ORM\Column(name: 'password', type: 'string', length: 60, nullable: false)]
    private string $password;
    
    #[Assert\NotBlank(groups: ['registration'])]
    #[Assert\Length(min: 7, groups: ['registration'])]
    private ?string $plainPassword = null;

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'confirmed_at', type: 'integer', nullable: true, options: ['default' => null])]
    private $confirmedAt = NULL;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'unconfirmed_email', type: 'string', length: 255, nullable: true, options: ['default' => null])]
    private $unconfirmedEmail;

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'blocked_at', type: 'integer', nullable: true, options: ['default' => null])]
    private $blockedAt = NULL;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'registration_ip', type: 'string', length: 45, nullable: true, options: ['default' => null])]
    private $registrationIp;

    /**
     * @var bool
     */
    #[ORM\Column(name: 'active', type: 'boolean', nullable: false, options: ['default' => 1])]
    private $active = true;
    
    /**
     * @var \DateTime|null
     */
    #[ORM\Column(name: 'deleted_at', type: 'datetime', nullable: true, options: ['default' => null])]
    private $deletedAt;
    /**
     * @var int|null
     */
    #[ORM\Column(name: 'last_login_at', type: 'integer', nullable: true, options: ['default' => null])]
    private $lastLoginAt = NULL;

    /**
     * @var Collection|UserRole[]
     */
    #[ORM\ManyToMany(targetEntity: UserRole::class, fetch: 'EAGER', inversedBy: 'users')]
    #[ORM\JoinTable(name: 'user_role_assigned', joinColumns: [new ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')], inverseJoinColumns: [new ORM\JoinColumn(name: 'role_id', referencedColumnName: 'id')])]
    private $roles;

    #[ORM\OneToOne(targetEntity: UserProfile::class, mappedBy: 'user', cascade:["persist", "remove"])]
    private ?UserProfile $profile;

    #[ORM\ManyToOne(targetEntity: UserType::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $type;

    /**
     * @var Collection|UserGroup[]
     */
    #[ORM\ManyToMany(targetEntity: UserGroup::class, inversedBy: 'users')]
    #[ORM\JoinTable(name: 'user_group_assigned')]
    private $groups;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->groups = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->username;
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
    
    public function getUsername(): ?string
    {
        return $this->username;
    }
    
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }
    
    public function getEmail(): ?string
    {
        return $this->email;
    }
    
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
    
    public function getConfirmedAt(): ?int
    {
        return $this->confirmedAt;
    }
    
    public function setConfirmedAt(?int $confirmedAt): self
    {
        $this->confirmedAt = $confirmedAt;

        return $this;
    }
    
    public function getUnconfirmedEmail(): ?string
    {
        return $this->unconfirmedEmail;
    }
    
    public function setUnconfirmedEmail(?string $unconfirmedEmail): self
    {
        $this->unconfirmedEmail = $unconfirmedEmail;

        return $this;
    }
    
    public function getBlockedAt(): ?int
    {
        return $this->blockedAt;
    }
    
    public function setBlockedAt(?int $blockedAt): self
    {
        $this->blockedAt = $blockedAt;

        return $this;
    }
    
    public function getRegistrationIp(): ?string
    {
        return $this->registrationIp;
    }
    
    public function setRegistrationIp(?string $registrationIp): self
    {
        $this->registrationIp = $registrationIp;

        return $this;
    }
    
    public function getTypeId(): ?int
    {
        return $this->typeId;
    }
    
    public function setTypeId(?int $typeId): self
    {
        $this->typeId = $typeId;

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
    
    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }
    
    public function getLastLoginAt(): ?int
    {
        return $this->lastLoginAt;
    }
    
    public function setLastLoginAt(?int $lastLoginAt): self
    {
        $this->lastLoginAt = $lastLoginAt;

        return $this;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        $roles = [];
        $defaultRoles[] = 'ROLE_USER';
        $rolesDB = $this->roles->toArray();
        
        foreach ($rolesDB as $role) {
            $roles[] = $role->getCode();
        }

        return array_unique(array_merge($defaultRoles, $roles));
    }
    
    public function addRole(Role $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles[] = $role;
            $role->addUser($this);
        }

        return $this;
    }
    
    public function removeRole(Role $role): self
    {
        if ($this->roles->removeElement($role)) {
            $role->removeUser($this);
        }

        return $this;
    }
    /**
     * @see PasswordAuthenticatedUserInterface
     */
    
    public function getPassword(): string
    {
        return $this->password;
    }
    
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }
    public function setPlainPassword(string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * The public representation of the user (e.g. a username, an email address, etc.)
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }
    
    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }
    /**
     * @see UserInterface
     */
    
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getProfile(): ?UserProfile
    {
        return $this->profile;
    }

    public function setProfile(?UserProfile $profile): self
    {
        // set the owning side of the relation if necessary
         if ($profile->getUser() !== $this) {
            $profile->setUser($this);
       }

        return $this;
    }

    public function getType(): ?UserType
    {
        return $this->type;
    }

    public function setType(?UserType $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, UserGroup>
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    public function addGroup(UserGroup $group): self
    {
        if (!$this->groups->contains($group)) {
            $this->groups[] = $group;
        }

        return $this;
    }

    public function removeGroup(UserGroup $group): self
    {
        $this->groups->removeElement($group);

        return $this;
    }
}