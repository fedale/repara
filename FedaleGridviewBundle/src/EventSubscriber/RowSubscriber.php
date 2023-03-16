<?php

namespace Fedale\GridviewBundle\EventSubscriber;

use Fedale\GridviewBundle\Event\RowEvent;
use Fedale\GridviewBundle\Grid\Gridviewinterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class RowSubscriber implements EventSubscriberInterface
{
    // public function __construct(private Gridviewinterface $gridview) {}

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
        $model = $event->row->data;
        if ($model['id'] % 2 === 0) {
            $event->row->setAttr('class', 'randomClass');
            $event->model['email'] = 'Email from onBeforeRow';
        }
    }

    public function onAfterRow(RowEvent $event)
    {
        $event->model['email'] = 'Email from onAfterRow';
    }
}