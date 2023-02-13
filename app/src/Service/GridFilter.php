<?php
namespace App\Service;

class GridFilter 
{
    public $filter = 'myFilter';

    public function setFilter(string $filter) 
    {
        $this->filter = $filter;
    }
}