<?php 
namespace App\Service;

use Fedale\GridviewBundle\Form\SearchModel;
use Fedale\GridviewBundle\Contract\SearchModelInterface;

class CustomerSearchModel extends SearchModel
{
    public function search() 
    {
        dd($this);
    }
}