<?php

namespace App\Grid\Column;

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
    protected bool $visible;
    
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

    public function getLabel()
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

    public function renderHeaderCell()
    {
        return 'HeaderCell';
    }

    public function renderFilterCell()
    {
        return 'FilterCell';
    }

    public function renderBodyCell()
    {
        return 'BodyCell';
    }

    public function renderFooterCell()
    {
        return 'FooterCell';
    }

    public function renderSummaryCell()
    {
        return 'SummaryCell';
    }
    

}