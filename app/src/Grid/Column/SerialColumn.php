<?php 
namespace App\Grid\Column;

class SerialColumn extends AbstractColumn {
    
    private $options;
    
    public function __construct($options)
    {
        $this->options = $options;    
    }

    public function renderValue()
    {
        return 'SerialColumn';
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