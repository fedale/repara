<?php

namespace App\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * UserAssignedCustomer
 */
#[ORM\Table(name: 'user_customer_assigned', uniqueConstraints: [new ORM\UniqueConstraint(name: 'customer_id_2', columns: ['customer_id', 'customer_location_id', 'customer_location_place_id', 'customer_place_asset_id', 'user_id'])], indexes: [new ORM\Index(name: 'updated_at', columns: ['updated_at']), new ORM\Index(name: 'user_id', columns: ['user_id']), new ORM\Index(name: 'customer_location', columns: ['customer_location_id']), new ORM\Index(name: 'active', columns: ['active']), new ORM\Index(name: 'customer_location_place', columns: ['customer_location_place_id']), new ORM\Index(name: 'created_at', columns: ['created_at']), new ORM\Index(name: 'customer_place_asset', columns: ['customer_place_asset_id']), new ORM\Index(name: 'customer_id', columns: ['customer_id'])])]
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
     * @var int
     */
    #[ORM\Column(name: 'user_id', type: 'integer', nullable: false, options: ['unsigned' => true])]
    private $userId;

    /**
     * @var int
     */
    #[ORM\Column(name: 'customer_id', type: 'integer', nullable: false, options: ['unsigned' => true])]
    private $customerId;

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'customer_location_id', type: 'integer', nullable: true, options: ['unsigned' => true])]
    private $customerLocationId = 0;

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'customer_location_place_id', type: 'integer', nullable: true, options: ['unsigned' => true])]
    private $customerLocationPlaceId = 0;

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'customer_place_asset_id', type: 'integer', nullable: true, options: ['unsigned' => true])]
    private $customerPlaceAssetId = 0;

    /**
     * @var bool
     */
    #[ORM\Column(name: 'active', type: 'boolean', nullable: false, options: ['default' => 1])]
    private $active = true;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getCustomerId(): ?int
    {
        return $this->customerId;
    }

    public function setCustomerId(int $customerId): self
    {
        $this->customerId = $customerId;

        return $this;
    }

    public function getCustomerLocationId(): ?int
    {
        return $this->customerLocationId;
    }

    public function setCustomerLocationId(?int $customerLocationId): self
    {
        $this->customerLocationId = $customerLocationId;

        return $this;
    }

    public function getCustomerLocationPlaceId(): ?int
    {
        return $this->customerLocationPlaceId;
    }

    public function setCustomerLocationPlaceId(?int $customerLocationPlaceId): self
    {
        $this->customerLocationPlaceId = $customerLocationPlaceId;

        return $this;
    }

    public function getCustomerPlaceAssetId(): ?int
    {
        return $this->customerPlaceAssetId;
    }

    public function setCustomerPlaceAssetId(?int $customerPlaceAssetId): self
    {
        $this->customerPlaceAssetId = $customerPlaceAssetId;

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
}
