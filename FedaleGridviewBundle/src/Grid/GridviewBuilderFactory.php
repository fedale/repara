<?php
namespace Fedale\GridviewBundle\Grid;

use Fedale\GridviewBundle\Form\FilterModelInterface;
use Fedale\GridviewBundle\Service\GridviewService;
use Twig\Environment;

class GridviewBuilderFactory 
{
    public function __construct(
        private Environment $twig,
        private GridviewService $gridviewService
    ) {}

    public function createGridviewBuilder(): GridviewBuilderInterface
    {
        // With an IF you can instantiate different type of GridviewBuilder
        // For example if ($this->config) {return new GridviewImplementation } else return new GridviewImplementation2
        return new GridviewBuilder($this->twig, $this->gridviewService);
    }
}