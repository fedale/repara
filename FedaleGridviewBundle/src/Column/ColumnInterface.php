<?php
namespace Fedale\GridviewBundle\Column;

use Fedale\GridviewBundle\Grid\Gridview;

interface ColumnInterface 
{
  public function isVisible();

  public function isFilterable();

  public function setGridview(Gridview $gridview);

  public function getAttribute();
}