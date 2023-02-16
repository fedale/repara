<?php
namespace App\Grid\Service;

use Doctrine\Common\Collections\Criteria;

class GridFilter
{
    public string $filter = 'myFilter';
    
    private $criteria;

    // public function __construct(private Criteria $criteria) {}

    public function setFilter(string $filter) 
    {
        $this->filter = $filter;
    }

    public function getCriteria() 
    {
        return $this->criteria;
    }

    public function setCriteria($criteria) 
    {
        $this->criteria = $criteria;
    }
}