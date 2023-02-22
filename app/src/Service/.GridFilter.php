<?php
namespace App\Service;

use Doctrine\Common\Collections\ArrayCollection;

class GridFilter 
{
    private ArrayCollection $filterCollection;

    public function __construct()
    {
        $this->filterCollection = new ArrayCollection();
    }

    public $filter = 'myFilter';

    public function setFilter(string $filter) 
    {
        $this->filter = $filter;
    }
}