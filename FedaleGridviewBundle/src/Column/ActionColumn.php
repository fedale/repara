<?php 
namespace Fedale\GridviewBundle\Column;

class ActionColumn extends AbstractColumn {
    
    
    public function initColumn()
    {
        $this->label = 'Action';
    }

    public function render($model, $index)
    {
        return 'actionColumn';
    }
}