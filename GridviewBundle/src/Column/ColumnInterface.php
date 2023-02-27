<?php
namespace Fedale\GridviewBundle\Column;

use Fedale\GridviewBundle\Gridview;

interface ColumnInterface 
{
  public function isVisible();

  public function setGridview(Gridview $gridview);
}