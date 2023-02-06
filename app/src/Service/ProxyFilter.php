<?php
namespace App\Service;

class ProxyFilter 
{
    public $filter = 'myFilter';

    public function setFilter(string $filter) 
    {
        $this->filter = $filter;
    }
}