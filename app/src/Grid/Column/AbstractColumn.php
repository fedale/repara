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
     * Twig instance
     * @var Environment 
     */
    protected Environment $twig;

    private $type;

    public function __construct($type)
    {
        $this->type = $type;
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