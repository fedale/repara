<?php
namespace App\Grid;

use Twig\Environment;

class GridviewBuilderFactory 
{
    public function __construct(
   //     private EntityManagerInterface $entityManager,
        private Environment $twig,
    ) {}

    public function createGridviewBuilder(): GridviewBuilderInterface
    {
        // With an IF you can instantiate different type of GridviewBuilder
        // For example if ($this->config) {return new GridviewImplementation } else return new GridviewImplementation2
        return new GridviewBuilder($this->twig);
    }
}