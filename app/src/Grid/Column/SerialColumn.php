<?php 
namespace App\Grid\Column;

class SerialColumn extends AbstractColumn {
    
    private $options;
    
    public function __construct($options)
    {
        $this->options = $options;    
    }

    public function getLabel(): string
    {
        return 'SerialColumn';
    }

}