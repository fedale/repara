<?php
namespace Fedale\Gridview;

use Fedale\Gridview\DataProvider\DataProviderInterface;
use Iterator;
use Traversable;

interface GridviewBuilderInterface
{
    public function setColumns(array $columns);
    
    public function setDataProvider(DataProviderInterface $dataProvider);

   
}
