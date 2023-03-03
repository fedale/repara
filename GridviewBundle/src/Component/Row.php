<?php 
namespace Fedale\GridviewBundle\Component;

class Row
{
    public array $data = []; 

    public array $htmlOptions = [];

    public function getKey(string $key) {
        return $this->data[$key];
    }
}