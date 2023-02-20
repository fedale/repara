<?php

namespace App\Grid\Event;

use Symfony\Contracts\EventDispatcher\Event;

class RowEvent extends Event
{
    public const NAME = 'row.before';
}