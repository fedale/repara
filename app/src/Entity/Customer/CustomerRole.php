<?php

namespace App\Entity\Customer;

use App\Repository\Customer\CustomerRoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: CustomerRoleRepository::class)]
class CustomerRole
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(name: 'slug', type: 'string', length: 64, nullable: false, unique: true)]
    #[Gedmo\Slug(fields: ['name'])]
    private $slug;

    #[ORM\Column(type: 'string', length: 64, nullable: false, unique: true)]
    private $code;

    #[ORM\ManyToMany(targetEntity: Customer::class, mappedBy: 'roles')]
    private $customers;

    #[ORM\ManyToMany(targetEntity: CustomerRole::class, mappedBy: 'children')]
    private Collection $parents;

    #[ORM\ManyToMany(targetEntity: CustomerRole::class, inversedBy: 'parents')]
    #[ORM\JoinTable(
        name: 'customer_role_hierarchy', 
        joinColumns: [new ORM\JoinColumn(name: 'parent', referencedColumnName: 'id')], 
        inverseJoinColumns: [new ORM\JoinColumn(name: 'child', referencedColumnName: 'id')]
    )]
    private Collection $children;

    public function __construct()
    {
        $this->customers = new ArrayCollection();
        $this->parents = new ArrayCollection();
        $this->children = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }
    
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCustomers(): Collection
    {
        return $this->customers;
    }

    public function addCustomer(Customer $customer): self
    {
        if (!$this->customers->contains($customer)) {
            $this->customers[] = $customer;
            $customer->addRole($this);
        }

        return $this;
    }

    public function removeCustomer(Customer $customer): self
    {
        if ($this->customers->removeElement($customer)) {
            $customer->removeRole($this);
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
