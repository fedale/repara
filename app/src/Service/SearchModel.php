<?php 
namespace App\Service;

use Fedale\GridviewBundle\Form\SearchModelInterface;

class SearchModel implements SearchModelInterface
{
    
    public function search($params) 
    {
        dd($this);
    }
}