<?php

namespace App\Entity\Customer;

use Gedmo\Timestampable\Traits\TimestampableEntity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Customer\Customer;
use App\Repository\Customer\CustomerLocationRepository;

#[ORM\Entity(CustomerLocationRepository::class)]
class CustomerLocation
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 128, nullable: false)]
    private string $name;

    #[ORM\Column(length: 64, nullable: false)]
    private string $address;

    #[ORM\Column(length: 8)]
    private ?string $zipcode = null;

    #[ORM\Column(length: 64, nullable: false)]
    private string $city;

    #[ORM\Column(length: 32, nullable:false)]
    private string $country = 'Italia';

    #[ORM\Column]
    private bool $active = true;

    /**
     * @var Customer
     *
     * @ ORM\ManyToOne(targetEntity="Customer")
     * @ ORM\JoinColumns({
     *   @ ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     * })
     */
    #[ORM\ManyToOne]
    private Customer $customer;


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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(?string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

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


    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }


}
