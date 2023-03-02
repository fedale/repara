<?php

namespace Fedale\GridviewBundle\Event;

use Symfony\Contracts\EventDispatcher\Event;

class RowEvent extends Event
{
    public const BEFORE_ROW = 'row.before_row';
    public const AFTER_ROW = 'row.after_row';

    public $model;
    public $gridview;
}