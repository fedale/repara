<?php 
namespace Fedale\Gridview\Column;

class CheckboxColumn extends AbstractColumn {
        
   public function render($model, $index)
   {
        return '<input type="checkbox">';
   }
}