<?php 

namespace Fedale\GridviewBundle\Component;

class Cell
{
    public array $data = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getKey(string $key) {
        return $this->data[$key];
    }
}