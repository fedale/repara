<?php

namespace App\Entity\Notification;

use Doctrine\ORM\Mapping as ORM;

/**
 * NotificationEntity
 */
#[ORM\Table(name: 'notification_entity', indexes: [new ORM\Index(name: 'name', columns: ['name']), new ORM\Index(name: 'subject', columns: ['subject'])])]
#[ORM\Entity]
class NotificationEntity
{
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
    #[ORM\Column(name: 'name', type: 'string', length: 64, nullable: false, options: ['comment' => 'post,comment,task,template'])]
    private $name;
    /**
     * @var string
     */
    #[ORM\Column(name: 'action', type: 'string', length: 16, nullable: false)]
    private $action;
    /**
     * @var string
     */
    #[ORM\Column(name: 'subject', type: 'string', length: 128, nullable: false)]
    private $subject;
    /**
     * @var string
     */
    #[ORM\Column(name: 'template', type: 'string', length: 255, nullable: false)]
    private $template;
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
    public function getAction(): ?string
    {
        return $this->action;
    }
    public function setAction(string $action): self
    {
        $this->action = $action;

        return $this;
    }
    public function getSubject(): ?string
    {
        return $this->subject;
    }
    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }
    public function getTemplate(): ?string
    {
        return $this->template;
    }
    public function setTemplate(string $template): self
    {
        $this->template = $template;

        return $this;
    }
}
