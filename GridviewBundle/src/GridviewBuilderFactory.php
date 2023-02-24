<?php
namespace Fedale\Gridview;

use Twig\Environment;

class GridviewBuilderFactory 
{
    public function __construct(
        private Environment $twig,
    ) {}

    public function createGridviewBuilder(): GridviewBuilderInterface
    {
        // With an IF you can instantiate different type of GridviewBuilder
        // For example if ($this->config) {return new GridviewImplementation } else return new GridviewImplementation2
        return new GridviewBuilder($this->twig);
    }
}