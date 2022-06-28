<?php

namespace App\EventSubscriber;

use App\Entity\Customer\Customer;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class PasswordPersistSubscriber implements EventSubscriberInterface
{
    private $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {     
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function onBeforeEntityPersistedEvent(BeforeEntityPersistedEvent $event): void
    {
        $entity = $event->getEntityInstance();
        if (!($entity instanceof Customer)) {
            return;
        }

        $entity->setPassword($this->userPasswordHasher->hashPassword($entity, $entity->getPassword()));
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => 'onBeforeEntityPersistedEvent',
        ];
    }
}
