<?php
namespace App\Grid;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;

class GridBuilder implements GridBuilderInterface 
{
    private Request $request;
    private Environment $twig;

    public function __construct(
        RequestStack $requestStack,
        Environment $twig
    )
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->twig = $twig;
    }

    public function renderGrid() {
        $this->renderToolbar();
        $this->renderHeader();
        $this->renderBody();
        $this->renderFooter();
        $this->renderSummary();
    }

    public function renderToolbar()
    {}
    
    public function renderHeader()
    {}

    public function renderBody()
    {}

    public function renderFooter()
    {}

    public function renderSummary()
    {}

    
}