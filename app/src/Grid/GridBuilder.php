<?php
namespace App\Grid;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;

class GridBuilder implements GridBuilderInterface 
{
    private Request $request;
    private Environment $twig;
    private Gridview $grid;

    public function __construct(
        RequestStack $requestStack,
        Environment $twig,
    )
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->twig = $twig;
        $this->reset();
    }

    public function reset()
    {
        $this->grid = new Gridview();
    }

    public function renderGrid() {
        $this->renderToolbar();
        $this->renderHeader();
        $this->renderBody();
        $this->renderFooter();
        $this->renderSummary();
    }

    public function renderToolbar()
    {
        return $this;
    }
    
    public function renderHeader()
    {
        return $this;
    }

    public function renderBody()
    {
        return $this;
    }

    public function renderFooter()
    {
        return $this;
    }

    public function renderSummary()
    {
        return $this;
    }

    
}