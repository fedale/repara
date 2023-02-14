<?php
namespace App\Grid\Service;

use Doctrine\Common\Collections\Criteria;

class GridFilter
{
    public string $filter = 'myFilter';
    public Criteria $criteria;

    public function setFilter(string $filter) 
    {
        $this->filter = $filter;
    }

    public function getCriteria() 
    {
        return $this->criteria;
    }

    public function setCriteria(Criteria $criteria) 
    {
        $this->criteria = $criteria;
    }
}