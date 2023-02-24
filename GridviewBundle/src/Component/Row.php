<?php 

namespace Fedale\Gridview\Component;

use ArrayIterator;

class Row extends ArrayIterator
{
    public array $data = [];

    public function __construct(array ...$data)
    {
        parent::__construct($data);
    }
    public function current() : array
    {
        return parent::current();
    }
    public function offsetGet($offset) : array
    {
        return parent::offsetGet($offset);
    }
}