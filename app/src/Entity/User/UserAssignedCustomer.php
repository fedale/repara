<?php

namespace App\Entity\User;

use App\Entity\Customer\Customer;
use App\Entity\Customer\CustomerLocation;
use App\Entity\Customer\CustomerLocationPlace;
use App\Entity\Customer\CustomerLocationPlaceAsset;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * UserAssignedCustomer
 */
#[ORM\Table(name: 'user_customer_assigned', 
    uniqueConstraints: [
        new ORM\UniqueConstraint(name: 'customer_id_2', columns: ['customer_id', 'customer_location_id', 'customer_location_place_id', 'customer_place_asset_id', 'user_id'])], 
    indexes: [
        new ORM\Index(name: 'updated_at', columns: ['updated_at']), 
        new ORM\Index(name: 'user_id', columns: ['user_id']), 
        new ORM\Index(name: 'customer_location', columns: ['customer_location_id']), 
        new ORM\Index(name: 'active', columns: ['active']), 
        new ORM\Index(name: 'customer_location_place', columns: ['customer_location_place_id']), 
        new ORM\Index(name: 'created_at', columns: ['created_at']), 
        new ORM\Index(name: 'customer_place_asset', columns: ['customer_place_asset_id']), 
        new ORM\Index(name: 'customer_id', columns: ['customer_id'])
    ]
)]
#[ORM\Entity]
class UserAssignedCustomer
{
    use TimestampableEntity;

    /**
     * @var int
     */
    #[ORM\Column(name: 'id', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private $id;
    
    /**
     * @var bool
     */
    #[ORM\Column(name: 'active', type: 'boolean', nullable: false, options: ['default' => 1])]
    private $active = true;

    #[ORM\Column(name: 'user_id', type: 'integer', nullable: false, options: ['unsigned' => true])]
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\Column(name: 'customer_id', type: 'integer', nullable: false, options: ['unsigned' => true])]
    #[ORM\ManyToOne(targetEntity: Customer::class)]
    private $customer;

    #[ORM\Column(name: 'customer_location_id', type: 'integer', nullable: true, options: ['unsigned' => true])]
    #[ORM\ManyToOne(targetEntity: CustomerLocation::class)]
    private $customerLocation;

    #[ORM\Column(name: 'customer_location_place_id', type: 'integer', nullable: true, options: ['unsigned' => true])]
    #[ORM\ManyToOne(targetEntity: CustomerLocationPlace::class)]
    private $customerLocationPlace;

    #[ORM\Column(name: 'customer_location_place_asset_id', type: 'integer', nullable: true, options: ['unsigned' => true])]
    #[ORM\ManyToOne(targetEntity: CustomerLocationPlaceAsset::class)]
    private $customerLocationPlaceAsset;


    public function getId(): ?int
    {
        return $this->id;
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

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getCustomerLocation(): ?CustomerLocation
    {
        return $this->customerLocation;
    }

    public function setCustomerLocation(?CustomerLocation $customerLocation): self
    {
        $this->customerLocation = $customerLocation;

        return $this;
    }

    public function getCustomerLocationPlace(): ?CustomerLocationPlace
    {
        return $this->customerLocationPlace;
    }

    public function setCustomerLocationPlace(?CustomerLocationPlace $customerLocationPlace): self
    {
        $this->customerLocationPlace = $customerLocationPlace;

        return $this;
    }

    public function getCustomerLocationPlaceAsset(): ?CustomerLocationPlaceAsset
    {
        return $this->customerLocationPlaceAsset;
    }

    public function setCustomerLocationPlaceAsset(?CustomerLocationPlaceAsset $customerLocationPlaceAsset): self
    {
        $this->customerLocationPlaceAsset = $customerLocationPlaceAsset;

        return $this;
    }
}