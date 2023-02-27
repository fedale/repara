<?php 
namespace Fedale\GridviewBundle\Column;

class CheckboxColumn extends AbstractColumn {
        
   public function render($model, $index)
   {
        return '<input type="checkbox">';
   }
}