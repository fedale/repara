<?php 
namespace App\Grid\Column;

use App\Grid\Gridview;

class SerialColumn extends AbstractColumn {

    // public function __construct(
    //     private Gridview $gridview,
    //     private ?string $attribute, 
    //     private string $format, 
    //     private ?string $label,
    //     private ?array $options = []
    // ) {
    //     $this->initContent();
    // }

    // private function initContent()
    // {
    //     $this->content = '1';
    // }

    public function render($model, $index)
    {
        return $model + 1;
    }
}