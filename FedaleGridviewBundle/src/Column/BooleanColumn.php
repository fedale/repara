<?php 
namespace Fedale\GridviewBundle\Column;

class BooleanColumn extends AbstractColumn {
        
    public function render($model, $index)
    {
        return 'BooleanColumn';
    }
}