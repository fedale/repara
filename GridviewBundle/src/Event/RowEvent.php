<?php

namespace Fedale\GridviewBundle\Event;

use Symfony\Contracts\EventDispatcher\Event;

class RowEvent extends Event
{
    public const NAME = 'row.before';
}