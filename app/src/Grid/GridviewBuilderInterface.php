<?php
namespace App\Grid;

interface GridviewBuilderInterface
{
    public function setColumns($columns);
    
    public function setSource($source);
   
}
