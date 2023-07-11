<?php 
namespace Fedale\GridviewBundle\Column;

use Fedale\GridviewBundle\Grid\Gridview;

class ActionColumn extends AbstractColumn {
    
    public $buttons = [];

    public function __construct (
        private Gridview $gridview,
        private string $attribute,
        protected ?string $twigFilter = null,
        protected ?string $label = null,
        protected ?array $options = [],
    ) { 
        if (null === $this->label) {
            $this->setLabel($attribute);
        }
        // Columns 'action' type is raw by default
        $this->setTwigfilter('raw');
        $this->initDefaultButtons();
    }

    public function getAttribute(): string
    {
        return $this->attribute;
    }

    public function initColumn()
    {
        $this->label = 'Action';      
    }

    private function initDefaultButtons() {
        $this->initDefaultButton('view');
        $this->initDefaultButton('update');
        $this->initDefaultButton('delete');
    }

    private function initDefaultButton(string $name,  array $options = null) {
        $this->buttons[$name] = '<a href="' . $name . '">' . $name . '</a>';
    }

    public function render($model, $index)
    {
        $content = '';
        foreach ($this->buttons as $button) {
            // $content .=  '<span class="button"><a href="/view/' . $model->data['id'] . '">' . $button . '</a></span>';
            $content .=  $button;
        }

        return $content;
    }

}