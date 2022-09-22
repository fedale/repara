<?php

namespace App\Entity\Notification;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\User\User;

/**
 * NotificationItem
 */
#[ORM\Table(name: 'notification_item', indexes: [new ORM\Index(name: 'notification_id', columns: ['notification_id']), new ORM\Index(name: 'sender_id', columns: ['sender_id']), new ORM\Index(name: 'recipient_id', columns: ['recipient_id']), new ORM\Index(name: 'status', columns: ['status'])])]
#[ORM\Entity]
class NotificationItem
{
     
    #[ORM\Column(name: 'id', type: 'integer', nullable: false, options: ['unsigned' => true])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private $id;
     
    #[ORM\Column(name: 'sender_id', type: 'integer', nullable: false, options: ['unsigned' => true])]
    private $senderId;
     
    #[ORM\Column(name: 'status', type: 'smallint', nullable: false)]
    private $status;
    /**
     * @var \Notification
     */
    #[ORM\ManyToOne(targetEntity: Notification::class)]
    #[ORM\JoinColumn(name: 'notification_id', referencedColumnName: 'id')]
    private $notification;
    /**
     * @var \AdminUser
     */
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'recipient_id', referencedColumnName: 'id')]
    private $recipient;
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getSenderId(): ?int
    {
        return $this->senderId;
    }
    public function setSenderId(int $senderId): self
    {
        $this->senderId = $senderId;

        return $this;
    }
    public function getStatus(): ?int
    {
        return $this->status;
    }
    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }
    public function getNotification(): ?Notification
    {
        return $this->notification;
    }
    public function setNotification(?Notification $notification): self
    {
        $this->notification = $notification;

        return $this;
    }
    public function getRecipient(): ?User
    {
        return $this->recipient;
    }
    public function setRecipient(?User $recipient): self
    {
        $this->recipient = $recipient;

        return $this;
    }
}
