<?php

namespace Fedale\GridviewBundle\EventSubscriber;

use Fedale\GridviewBundle\Event\RowEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class RowSubscriber implements EventSubscriberInterface
{
    // Returns an array indexed by event name and value by method name to call
    public static function getSubscribedEvents()
    {
        return [
            RowEvent::NAME => 'onRowCreation',
        ];
    }

    public function onRowCreation(RowEvent $event)
    {
        dump($event);
        $model = $event->model;
        if ($model['id'] % 2 === 0) {
            $event->model['email'] = 'Email from OnRowCreation';
        }
        
    }
}