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
            RowEvent::BEFORE_ROW => 'onBeforeRow',
            RowEvent::AFTER_ROW => 'onAfterRow',
        ];
    }

    public function onBeforeRow(RowEvent $event)
    {
        $model = $event->model;
        if ($model['id'] % 2 === 0) {
            $event->model['email'] = 'Email from onBeforeRow';
        }

        $event->gridview->rowOptions = ['id' => 'k1', 'class' => 'c1'];

    }

    public function onAfterRow(RowEvent $event)
    {
        $event->model['email'] = 'Email from onAfterRow';
    }
}