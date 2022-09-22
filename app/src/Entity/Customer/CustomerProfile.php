<?php

namespace App\Entity\Customer;

use Doctrine\ORM\Mapping as ORM;

/**
 * CustomerProfile
 */
#[ORM\Table(name: 'customer_profile')]
#[ORM\Entity]
class CustomerProfile
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy:'AUTO')]
    #[ORM\Column]
    private $id;

    #[ORM\OneToOne(targetEntity: Customer::class, inversedBy: 'profile', cascade: ['persist', 'remove'])]
    private $customer;
    
    /**
     * @var string|null
     */
    #[ORM\Column(name: 'firstname', type: 'string', length: 255, nullable: true, options: ['default' => null])]
    private $firstname = NULL;
     
    #[ORM\Column(name: 'lastname', type: 'string', length: 64, nullable: false)]
    private $lastname;
    /**
     * @var string|null
     */
    #[ORM\Column(name: 'public_email', type: 'string', length: 255, nullable: true, options: ['default' => null])]
    private $publicEmail = NULL;
    /**
     * @var string|null
     */
    #[ORM\Column(name: 'gravatar_email', type: 'string', length: 255, nullable: true, options: ['default' => null])]
    private $gravatarEmail = NULL;
    /**
     * @var string|null
     */
    #[ORM\Column(name: 'gravatar_id', type: 'string', length: 32, nullable: true, options: ['default' => null])]
    private $gravatarId = NULL;
    /**
     * @var string|null
     */
    #[ORM\Column(name: 'location', type: 'string', length: 255, nullable: true, options: ['default' => null])]
    private $location = NULL;
    /**
     * @var string|null
     */
    #[ORM\Column(name: 'website', type: 'string', length: 255, nullable: true, options: ['default' => null])]
    private $website = NULL;
    /**
     * @var string|null
     */
    #[ORM\Column(name: 'bio', type: 'text', length: 65535, nullable: true, options: ['default' => null])]
    private $bio = NULL;
    /**
     * @var string|null
     */
    #[ORM\Column(name: 'timezone', type: 'string', length: 40, nullable: true, options: ['default' => null])]
    private $timezone = NULL;
    /**
     * @var string|null
     */
    #[ORM\Column(name: 'setting', type: 'text', length: 0, nullable: true, options: ['default' => null, 'comment' => 'settings preferences'])]
    private $setting = NULL;

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->getFullname();
    }
    
    public function getFullname()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }
    public function setFirstname(?string $firstname): self
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
    public function getPublicEmail(): ?string
    {
        return $this->publicEmail;
    }
    public function setPublicEmail(?string $publicEmail): self
    {
        $this->publicEmail = $publicEmail;

        return $this;
    }
    public function getGravatarEmail(): ?string
    {
        return $this->gravatarEmail;
    }
    public function setGravatarEmail(?string $gravatarEmail): self
    {
        $this->gravatarEmail = $gravatarEmail;

        return $this;
    }
    public function getGravatarId(): ?string
    {
        return $this->gravatarId;
    }
    public function setGravatarId(?string $gravatarId): self
    {
        $this->gravatarId = $gravatarId;

        return $this;
    }
    public function getLocation(): ?string
    {
        return $this->location;
    }
    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }
    public function getWebsite(): ?string
    {
        return $this->website;
    }
    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }
    public function getBio(): ?string
    {
        return $this->bio;
    }
    public function setBio(?string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }
    public function getTimezone(): ?string
    {
        return $this->timezone;
    }
    public function setTimezone(?string $timezone): self
    {
        $this->timezone = $timezone;

        return $this;
    }
    public function getSetting(): ?string
    {
        return $this->setting;
    }
    public function setSetting(?string $setting): self
    {
        $this->setting = $setting;

        return $this;
    }

   
    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }


}
