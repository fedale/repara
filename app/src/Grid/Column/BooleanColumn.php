<?php 
namespace App\Grid\Column;

class BooleanColumn extends AbstractColumn {
        
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