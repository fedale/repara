<?php

namespace App\Entity\Customer;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * CustomerContact
 */
#[ORM\Table(name: 'customer_contact', uniqueConstraints: [new ORM\UniqueConstraint(name: 'email', columns: ['email', 'location_id']), new ORM\UniqueConstraint(name: 'phone', columns: ['phone', 'location_id'])], indexes: [new ORM\Index(name: 'active', columns: ['active']), new ORM\Index(name: 'firstname', columns: ['firstname']), new ORM\Index(name: 'created_at', columns: ['created_at']), new ORM\Index(name: 'lastname', columns: ['lastname']), new ORM\Index(name: 'updated_at', columns: ['updated_at']), new ORM\Index(name: 'location_id', columns: ['location_id'])])]
#[ORM\Entity]
class CustomerContact
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
    #[ORM\Column(name: 'firstname', type: 'string', length: 64, nullable: false)]
    private $firstname;
    
    /**
     * @var string
     */
    #[ORM\Column(name: 'lastname', type: 'string', length: 64, nullable: false)]
    private $lastname;
    
    /**
     * @var string|null
     */
    #[ORM\Column(name: 'phone', type: 'string', length: 32, nullable: true, options: ['default' => null])]
    private $phone = null;
    
    /**
     * @var string|null
     */
    #[ORM\Column(name: 'email', type: 'string', length: 32, nullable: true, options: ['default' => null])]
    private $email = null;
    
    /**
     * @var bool
     */
    #[ORM\Column(name: 'active', type: 'boolean', nullable: false, options: ['default' => 1])]
    private $active = true;
    
    /**
     * @var CustomerLocation
     */
    #[ORM\ManyToOne(targetEntity: 'CustomerLocation')]
    #[ORM\JoinColumn(name: 'location_id', referencedColumnName: 'id')]
    private $location;
    
    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }
    
    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }
    
    public function getLastname(): ?string
    {
        return $this->lastname;
    }
    
    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }
    
    public function getPhone(): ?string
    {
        return $this->phone;
    }
    
    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }
    
    public function getEmail(): ?string
    {
        return $this->email;
    }
    
    public function setEmail(?string $email): self
    {
        $this->email = $email;

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
    
    public function isActive(): ?bool
    {
        return $this->active;
    }
    
    public function getLocation(): ?CustomerLocation
    {
        return $this->location;
    }
    public function setLocation(?CustomerLocation $location): self
    {
        $this->location = $location;

        return $this;
    }
}
