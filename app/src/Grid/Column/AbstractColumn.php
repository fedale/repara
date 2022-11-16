<?php

namespace App\Grid\Column;

use App\Grid\Gridview;
use Twig\Environment;

abstract class AbstractColumn implements ColumnInterface
{
    /**
     * An unique identifier for the Column
     * @var string 
     */
    protected string $key;

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

     /**
     * @var string|null Column header label
     */
    protected ?string $label = null;

    /**
     * @var Gridview
     */
    protected Gridview $gridview;

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
    protected $content;

    /**
     * Twig instance
     * @var Environment 
     */
    protected Environment $twig;

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

    
}