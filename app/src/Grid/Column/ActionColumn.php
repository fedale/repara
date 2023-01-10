<?php 
namespace App\Grid\Column;

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