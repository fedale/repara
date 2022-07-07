<?php

namespace App\Entity\Customer;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity()]
class Customer implements UserInterface, PasswordAuthenticatedUserInterface
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 64, nullable: false, unique: true)]
    private string $code;

    #[ORM\Column(length: 255, nullable: false, unique: true)]
    private string $username;

    #[ORM\Column(length: 255, nullable: false, unique: true)]
    private string $email;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $password;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $unconfirmedEmail;

    #[ORM\Column(length: 64, nullable: true)]
    private ?string $registrationIp;

    #[ORM\Column(nullable: false)]
    private bool $active = true;

    #[ORM\Column(nullable: true)]
    private \DateTime $confirmedAt;

    #[ORM\Column(nullable: true)]
    private \DateTime $lastLoginAt;

    #[ORM\Column(nullable: true)]
    private \DateTime $blockedAt;

    private array $roles = [];

    #[ORM\OneToMany(mappedBy: 'customer', targetEntity: CustomerLocation::class)]
    private $locations;

    #[ORM\ManyToOne(targetEntity: CustomerType::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $type;

    #[ORM\ManyToMany(targetEntity: CustomerGroup::class, inversedBy: 'customers')]
    private $groups;

    

    public function __construct()
    {
        $this->locations = new ArrayCollection();
        $this->groups = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getFullname();
    }
    
    public function getFullname()
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

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


    public function getRoles(): array
    {
        return ['ROLE'];
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

    /*
    public function getProfile(): ?CustomerProfile
    {
        return $this->profile;
    }

    public function setProfile(CustomerProfile $profile): self
    {
        // // set the owning side of the relation if necessary
        if ($profile->getProfile() !== $this) {
            $customer->setProfile($this);
       }

        $this->profile = $profile;

        return $this;
    }
    */

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
        }

        return $this;
    }

    public function removeGroup(CustomerGroup $group): self
    {
        $this->groups->removeElement($group);

        return $this;
    }

    

}
