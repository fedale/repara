<?php 
namespace App\Service;

use Fedale\GridviewBundle\Service\SearchModelInterface;

class SearchModel implements SearchModelInterface
{
    
    public function search($params) 
    {
        dd($this);
    }
}