<?php
namespace App\Grid;

use App\Grid\DataProvider\DataProviderInterface;
use Iterator;
use Traversable;

interface GridviewBuilderInterface
{
    public function setColumns(array $columns);
    
    public function setDataProvider(DataProviderInterface $dataProvider);

   
}
