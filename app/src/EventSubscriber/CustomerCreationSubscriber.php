<?php

namespace App\EventSubscriber;

use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CustomerCreationSubscriber implements EventSubscriberInterface
{
    public function onAfterEntityPersistedEvent(BeforeEntityPersistedEvent $event): void
    {
        // dd($event);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => 'onAfterEntityPersistedEvent',
        ];
    }
}
