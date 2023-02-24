<?php
namespace Fedale\Gridview\Column;

use Fedale\Gridview\Gridview;

interface ColumnInterface 
{
  public function isVisible();

  public function setGridview(Gridview $gridview);
}