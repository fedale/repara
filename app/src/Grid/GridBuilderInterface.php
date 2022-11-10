<?php
namespace App\Grid;

interface GridBuilderInterface
{
    public function renderToolbar();
    
    public function renderHeader();

    public function renderBody();

    public function renderFooter();

    public function renderSummary();
    
}
