<?php

namespace Fedale\GridviewBundle\Column;

use Fedale\GridviewBundle\Gridview;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormInterface;
use Twig\Environment;

abstract class AbstractColumn implements ColumnInterface
{

     /**
     * @var callable This is a callable that will be used to generate the content of each cell.
     * The signature of the function should be the following: `function ($model, $key, $index, $column)`.
     * Where `$model`, `$key`, and `$index` refer to the model, key and index of the row currently being rendered
     * and `$column` is a reference to the [[Column]] object.
     */
    public $content;

    /**
     * Whether column is visible or not 
     * @var bool 
     */
    protected bool $visible = true;

    /**
     * Whether column is sortable or not 
     * @var bool 
     */
    protected bool $sortable = true;

    /**
     * Whether column is filterable or not 
     * @var bool 
     */
    protected bool $filterable = true;
    
    /**
     * Whether column is hidden or not 
     * @var bool 
     */
    protected bool $hidden;
    
    /**
     * Whether column is exportable or not 
     * @var bool 
     */
    protected bool $exportable;

    //  /**
    //   * Column header label
    //   * @var string|null 
    //   */
    //private ?string $label = null;

    // /**
    //  * @var Gridview
    //  */
    // protected Gridview $gridview;

    /**
     * @var string|callable Column cell content. This parameter can contain
     * string value or callback function.
     *
     * Example with string value:
     * 'content' => 'some value',
     *
     * Callable function takes two parameters:
     *  - $entity - instance of entity
     *  - $rowIndex - index of current row
     * Example:
     * 'content' => function ($entity, $rowIndex) {
     *     return $entity->getCustomFieldValue();
     * },
     */
    protected $value;

    /**
     * Twig instance
     * @var Environment 
     */
    protected Environment $twig;

    public function __construct (
        private Gridview $gridview,
        protected ?string $twigFilter = null, 
        protected ?string $label = null,
        protected ?array $options = []
    ) {
        
        $this->initColumn();
    }

    protected function initColumn()
    {
      //  $content = $this->setContent($this->attribute);
    }

    public function renderFilter(FormBuilder $form )
    {
        $form->add('name', TextType::class);
        //return '<input type="text" name="{{column.label}}" placeholder="" style="background-color: #404040; border: 0">';
    }

    public function render($data, $index)
    {
        return $data[$this->content];
    }

    public function getContent()
    {
        return $this->content;
    }
    
    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

     /**
     * @param mixed $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    public function getTwigFilter(): ?string
    {
        return $this->twigFilter;
    }

    public function setTwigFilter(string $twigFilter)
    {
        $this->twigFilter = $twigFilter;
    }

    /**
     * @return boolean
     */
    public function isVisible(): bool
    {
        return $this->visible;
    }

    /**
     * @param callable $enabled
     *
     * @return $this
     */
    public function setVisible($visible): static
    {
        if ($visible instanceof \Closure) {
            $this->visible = call_user_func($visible);
        } else {
            $this->visible = (bool)$visible;
        }

        return $this;
    }

    /**
     * @return boolean
     */
    public function isSortable(): bool
    {
        return $this->sortable;
    }

    /**
     * @param callable $enabled
     *
     * @return $this
     */
    public function setSortable($sortable): static
    {
        if ($sortable instanceof \Closure) {
            $this->sortable = call_user_func($sortable);
        } else {
            $this->sortable = (bool)$sortable;
        }

        return $this;
    }

    /**
     * @return boolean
     */
    public function isFilterable(): bool
    {
        return $this->filterable;
    }

    /**
     * @param callable $enabled
     *
     * @return $this
     */
    public function setFilterable($filterable): static
    {
        if ($filterable instanceof \Closure) {
            $this->filterable = call_user_func($filterable);
        } else {
            $this->filterable = (bool)$filterable;
        }

        return $this;
    }

    /**
     * @param Gridview $gridview
     */
    public function setGridview(Gridview $gridview)
    {
        $this->gridview = $gridview;
    }

    public function renderHeader($label): string
    {
        return 'label';
    }
}