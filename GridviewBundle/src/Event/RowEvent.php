<?php

namespace Fedale\Gridview\Event;

use Symfony\Contracts\EventDispatcher\Event;

class RowEvent extends Event
{
    public const NAME = 'row.before';
}