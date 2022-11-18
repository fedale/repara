<?php
namespace App\Grid\Column;

interface ColumnInterface 
{
    /**
     * @string Column label
     */
    public function getLabel(): string;
   
}