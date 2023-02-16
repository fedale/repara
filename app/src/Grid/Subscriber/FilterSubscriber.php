<?php
// src/Form/EventListener/AddEmailFieldListener.php
namespace App\Grid\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class FilterSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            // FormEvents::PRE_SET_DATA => 'onPreSetData',
            //FormEvents::PRE_SUBMIT   => 'onPreSubmit',
            FormEvents::POST_SUBMIT   => 'onPostSubmit',
        ];
    }

    public function onPreSetData(FormEvent $event): void
    {
    //     $user = $event->getData();
    //     $form = $event->getForm();
    //     //$this->logActivity('persist', $args);
    // }

    //     // checks whether the user from the initial data has chosen to
    //     // display their email or not.
    //     if (true === $user->isShowEmail()) {
    //         $form->add('email', EmailType::class);
    //     }
    }

    public function onPostSubmit(FormEvent $event): void
    {
        $user = $event->getData();
        $form = $event->getForm();

        dump($user, $form);
        
        if (!$user) {
            return;
        }

        // checks whether the user has chosen to display their email or not.
        // If the data was submitted previously, the additional value that
        // is included in the request variables needs to be removed.
        if (isset($user['showEmail']) && $user['showEmail']) {
            $form->add('email', EmailType::class);
        } else {
            unset($user['email']);
            $event->setData($user);
        }
    }
}