<?php
namespace App\Grid;

interface GruidBuilderInterface
{
    public function renderToolbar();
    
    public function renderHeader();

    public function renderBody();

    public function renderFooter();

    public function renderSummary();
    
}
