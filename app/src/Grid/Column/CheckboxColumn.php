<?php 
namespace App\Grid\Column;

class CheckboxColumn extends AbstractColumn {
        
   public function render($model, $index)
   {
        return '<input type="checkbox">';
   }
}