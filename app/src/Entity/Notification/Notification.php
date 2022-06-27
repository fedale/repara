<?php

namespace App\Entity\Notification;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notification
 */
#[ORM\Table(name: 'notification', indexes: [new ORM\Index(name: 'entity_type_id', columns: ['notification_entity_id']), new ORM\Index(name: 'updated_at', columns: ['updated_at']), new ORM\Index(name: 'entity_id', columns: ['entity_id']), new ORM\Index(name: 'active', columns: ['status']), new ORM\Index(name: 'created_at', columns: ['created_at'])])]
#[ORM\Entity]
class Notification
{
    /**
     * @var int
     */
    #[ORM\Column(name: 'id', type: 'integer', nullable: false, options: ['unsigned' => true])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private $id;
    /**
     * @var int|null
     */
    #[ORM\Column(name: 'entity_id', type: 'integer', nullable: true, options: ['default' => null, 'unsigned' => true, 'comment' => 'NULL with deleted entities'])]
    private $entityId = NULL;
    /**
     * @var string
     */
    #[ORM\Column(name: 'message', type: 'text', length: 16777215, nullable: false)]
    private $message;
    /**
     * @var bool
     */
    #[ORM\Column(name: 'status', type: 'boolean', nullable: false, options: ['default' => 1])]
    private $status = true;
    /**
     * @var \DateTime
     */
    #[ORM\Column(name: 'created_at', type: 'datetime', nullable: false, options: ['default' => 'current_timestamp()'])]
    private $createdAt = 'current_timestamp()';
    /**
     * @var \DateTime
     */
    #[ORM\Column(name: 'updated_at', type: 'datetime', nullable: false, options: ['default' => 'current_timestamp()'])]
    private $updatedAt = 'current_timestamp()';
    /**
     * @var \DateTime|null
     */
    #[ORM\Column(name: 'deleted_at', type: 'datetime', nullable: true, options: ['default' => null])]
    private $deletedAt = 'NULL';
    /**
     * @var \NotificationEntity
     */
    #[ORM\ManyToOne(targetEntity: 'NotificationEntity')]
    #[ORM\JoinColumn(name: 'notification_entity_id', referencedColumnName: 'id')]
    private $notificationEntity;
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getEntityId(): ?int
    {
        return $this->entityId;
    }
    public function setEntityId(?int $entityId): self
    {
        $this->entityId = $entityId;

        return $this;
    }
    public function getMessage(): ?string
    {
        return $this->message;
    }
    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }
    public function getStatus(): ?bool
    {
        return $this->status;
    }
    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }
    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }
    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }
    public function getNotificationEntity(): ?NotificationEntity
    {
        return $this->notificationEntity;
    }
    public function setNotificationEntity(?NotificationEntity $notificationEntity): self
    {
        $this->notificationEntity = $notificationEntity;

        return $this;
    }
}
