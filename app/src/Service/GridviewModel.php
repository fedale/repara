<?php 
namespace App\Service;

use Fedale\GridviewBundle\Service\GridviewModelInterface;

class GridviewModel implements GridviewModelInterface{

    public function search($params) 
    {
        dd($this);
    }
}