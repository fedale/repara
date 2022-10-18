<?php 
namespace App\Grid;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class Column {
        
    public function renderCell(): string
    {
        return 'value';
    }
}