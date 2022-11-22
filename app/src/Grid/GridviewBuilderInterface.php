<?php
namespace App\Grid;

use App\Grid\DataProvider\DataProviderInterface;

interface GridviewBuilderInterface
{
    public function setColumns($columns);
    
    public function setDataProvider(DataProviderInterface $dataProvider);

   
}
