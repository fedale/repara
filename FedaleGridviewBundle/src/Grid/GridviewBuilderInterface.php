<?php
namespace Fedale\GridviewBundle\Grid;

use Fedale\GridviewBundle\DataProvider\DataProviderInterface;
use Iterator;
use Traversable;

interface GridviewBuilderInterface
{
   // public function setColumns(array $columns);
    
    // public function setDataProvider(DataProviderInterface $dataProvider);
    public function setDataProvider(array $dataProviderOptions);
   
    //public function setSearchModel();
}
