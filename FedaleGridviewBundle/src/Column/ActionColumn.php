<?php 
namespace Fedale\GridviewBundle\Column;

use Fedale\GridviewBundle\Grid\Gridview;

class ActionColumn extends AbstractColumn {
    
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
    }

    public function getAttribute(): string
    {
        return $this->attribute;
    }

    public function initColumn()
    {
        $this->label = 'Action';
    }

    public function render($model, $index)
    {
        dump($this->getGridview());
        dump($model->data['id']);
        $b1 = '<a href="/view/' . $model->data['id'] . '" aria-label="View">View</a>';
        $b2 = '<a href="/edit/' . $model->data['id'] . '" aria-label="Edit">Edit</a>';
        $b3 = '<a href="/delete/' . $model->data['id'] . '" aria-label="Delete">Delete</a>';
        
        $b4 = '<a href="{{ path(\'app_user_user_crud_show\', {\'id\': user.id}) }}">show</a>';
        $b5 = '<a href="{{ path(\'app_user_user_crud_edit\', {\'id\': user.id}) }}">edit</a>';
        
        return $b4 . $b5;
    }

    public function getOptions()
    {
        return ['id' => 'id_1', 'class' => 'my-class', 'attr' => 'my-custom.attribute'];
    }
}