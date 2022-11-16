<?php
namespace App\Grid\Column;

interface ColumnInterface 
{
    /**
     * @string Column label
     */
    public function getLabel(): string;
    // public function renderHeaderCell();

    // public function renderFilterCell();

    // public function renderBodyCell();

    // public function renderFooterCell();

    // public function renderSummaryCell();

}