<?php

namespace App\Entity\Notification;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Notification
 */
#[ORM\Table(name: 'notification', indexes: [new ORM\Index(name: 'entity_type_id', columns: ['notification_entity_id']), new ORM\Index(name: 'updated_at', columns: ['updated_at']), new ORM\Index(name: 'entity_id', columns: ['entity_id']), new ORM\Index(name: 'active', columns: ['status']), new ORM\Index(name: 'created_at', columns: ['created_at'])])]
#[ORM\Entity]
class Notification
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
     * @var NotificationEntity
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
