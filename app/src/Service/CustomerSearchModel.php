<?php 
namespace App\Service;

use Fedale\GridviewBundle\Service\SearchModel;
use Fedale\GridviewBundle\Service\SearchModelInterface;

class CustomerSearchModel extends SearchModel
{
    public function search($params) 
    {
        dd($this);
    }
}