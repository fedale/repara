<?php

namespace App\Entity\Customer;

use App\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass:'App\Repository\Customer\CustomerRepository')]
#[UniqueEntity('email')]
#[UniqueEntity('code')]
#[UniqueEntity('username')]
class Customer implements UserInterface, PasswordAuthenticatedUserInterface
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\Column(type: 'integer', nullable: false)]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private $id;

    #[ORM\Column(length: 64, nullable: false, unique: true)]
    #[Assert\NotBlank()]
    private string $code;

    #[ORM\Column(length: 255, nullable: false, unique: true)]
    private string $username;

    #[ORM\Column(length: 255, nullable: false, unique: true)]
    #[Assert\Email]
    private string $email;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $password;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $unconfirmedEmail;

    #[ORM\Column(length: 64, nullable: true)]
    private ?string $registrationIp;

    #[ORM\Column()]
    private bool $active = true;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $confirmedAt;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $lastLoginAt;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $blockedAt;

    #[ORM\OneToOne(targetEntity: CustomerProfile::class, mappedBy: 'customer', cascade: ['persist', 'remove'])]
    #[MaxDepth(1)]
    private ?CustomerProfile $profile;

    #[ORM\OneToMany(targetEntity: CustomerLocation::class, mappedBy: 'customer')]
    #[MaxDepth(1)]
    private $locations;

    #[ORM\ManyToOne(targetEntity: CustomerType::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Ignore]
    #[MaxDepth(1)]
    private $type;

    #[ORM\ManyToMany(targetEntity: CustomerGroup::class, inversedBy: 'customers')]
    #[ORM\JoinTable(name: 'customer_group_assigned')]
    #[Ignore]
    #[MaxDepth(1)]
    private $groups;

    #[ORM\ManyToMany(targetEntity: CustomerRole::class, inversedBy: 'customers')]
    #[ORM\JoinTable(name: 'customer_role_assigned', joinColumns: [new ORM\JoinColumn(name: 'customer_id', referencedColumnName: 'id')], inverseJoinColumns: [new ORM\JoinColumn(name: 'role_id', referencedColumnName: 'id')])]
    #[Ignore]
    #[MaxDepth(1)]
    private $roles;

    #[Assert\NotBlank(groups: ['registration'])]
    #[Assert\Length(min: 7, groups: ['registration'])]
    private ?string $plainPassword = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'assignedCustomers')]
    #[Ignore]
    #[MaxDepth(1)]
    private Collection $users;

    // private $virtualField;

    public function __construct()
    {
        $this->locations = new ArrayCollection();
        $this->groups = new ArrayCollection();
        $this->roles = new ArrayCollection();
        $this->users = new ArrayCollection();
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

    public function getSalt(): ?string
    {
        return null;
    }
    
    public function getPassword(): ?string
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

    public function getUnconfirmedEmail(): ?string
    {
        return $this->unconfirmedEmail;
    }

    public function setUnconfirmedEmail(?string $unconfirmedEmail): self
    {
        $this->unconfirmedEmail = $unconfirmedEmail;

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

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getConfirmedAt(): ?\DateTimeInterface
    {
        return $this->confirmedAt;
    }

    public function setConfirmedAt(?\DateTimeInterface $confirmedAt): self
    {
        $this->confirmedAt = $confirmedAt;

        return $this;
    }

    public function getLastLoginAt(): ?\DateTimeInterface
    {
        return $this->lastLoginAt;
    }

    public function setLastLoginAt(?\DateTimeInterface $lastLoginAt): self
    {
        $this->lastLoginAt = $lastLoginAt;

        return $this;
    }

    public function getBlockedAt(): ?\DateTimeInterface
    {
        return $this->blockedAt;
    }

    public function setBlockedAt(?\DateTimeInterface $blockedAt): self
    {
        $this->blockedAt = $blockedAt;

        return $this;
    }

    
    public function isActive(): ?bool
    {
        return $this->active;
    }


    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
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
     * @return Collection<int, CustomerLocation>
     */
    public function getLocations(): Collection
    {
        return $this->locations;
    }

    public function addLocation(CustomerLocation $location): self
    {
        if (!$this->locations->contains($location)) {
            $this->locations[] = $location;
            $location->setCustomer($this);
        }

        return $this;
    }

    public function removeLocation(CustomerLocation $location): self
    {
        if ($this->locations->removeElement($location)) {
            // set the owning side to null (unless already changed)
            if ($location->getCustomer() === $this) {
                $location->setCustomer(null);
            }
        }

        return $this;
    }

    
    public function getProfile(): ?CustomerProfile
    {
        return $this->profile;
    }

    public function setProfile(CustomerProfile $profile): self
    {
        // set the owning side of the relation if necessary
         if ($profile->getCustomer() !== $this) {
             $profile->setCustomer($this);
        }

        $this->profile = $profile;

        return $this;
    }
    

    public function getType(): ?CustomerType
    {
        return $this->type;
    }

    public function setType(?CustomerType $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, CustomerGroup>
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    public function addGroup(CustomerGroup $group): self
    {
        if (!$this->groups->contains($group)) {
            $this->groups[] = $group;
            $group->addCustomer($this);
        }

        return $this;
    }

    public function removeGroup(CustomerGroup $group): self
    {
        if ($this->groups->removeElement($group)) {
            $group->removeCustomer($this);
        }
        
        return $this;
    }

    public function getRoles(): array
    {
        $roles = [];
        $rolesDB = $this->roles->toArray();
        foreach ($rolesDB as $role) {
            $roles[] = $role->getCode();
        }
        $roles[] = 'ROLE_USER';

        return $roles;
    }
    
    public function addRole(CustomerRole $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles[] = $role;
            $role->addUser($this);
        }

        return $this;
    }
    
    public function removeRole(CustomerRole $role): self
    {
        if ($this->roles->removeElement($role)) {
            $role->removeUser($this);
        }

        return $this;
    }

    // /**
    //  * @return Collection<int, CustomerRole>
    //  */
    // public function getRoles2(): Collection
    // {
    //     return $this->roles2;
    // }

    // public function addRoles2(CustomerRole $roles2): self
    // {
    //     if (!$this->roles2->contains($roles2)) {
    //         $this->roles2[] = $roles2;
    //     }

    //     return $this;
    // }

    // public function removeRoles2(CustomerRole $roles2): self
    // {
    //     $this->roles2->removeElement($roles2);

    //     return $this;
    // }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addAssignedCustomer($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeAssignedCustomer($this);
        }

        return $this;
    }

    // public function getVirtualField() {
    //     return $this->virtualField;
    // }

    // public function setVirtualField(string $virtualField) {
    //     $this->virtualField = $virtualField;

    //     return $this;
    // }

    public function getFullcode()
    {
        return $this->id . ' ' . $this->email;
    }

}