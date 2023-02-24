<?php
namespace App\Grid\Column;

use App\Grid\Gridview;

interface ColumnInterface 
{
  public function isVisible();

  public function setGridview(Gridview $gridview);
}