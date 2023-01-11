<?php

namespace App\Grid\Column;

use App\Grid\Gridview;
use Twig\Environment;

abstract class AbstractColumn implements ColumnInterface
{
    // /**
    //  * An unique identifier for the Column
    //  * @var string 
    //  */
    // protected string $key;

     /**
     * @var ColumnFormat
     */
    protected ColumnFormat $columnFormat;

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
        protected ?string $format = ColumnFormat::RAW_FORMAT, 
        protected ?string $label = null,
        protected ?array $options = [],
        protected ?string $twigFilter = null
    ) {
        
        $this->initColumn();
    }

    protected function initColumn()
    {
      //  $content = $this->setContent($this->attribute);
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

    public function setTwigFilter($twigFilter)
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
    public function setVisible($enabled): static
    {
        if ($enabled instanceof \Closure) {
            $this->visible = call_user_func($enabled);
        } else {
            $this->visible = (bool)$enabled;
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

    public function getHeader(): string
    {
        return $this->label;
    }

    public function getFormat(): string
    {
        return $this->format;
    }
    
    /**
     * @param string $format
     */
    public function setFormat(string $format)
    {
        $this->format = $format;
    }
    
}