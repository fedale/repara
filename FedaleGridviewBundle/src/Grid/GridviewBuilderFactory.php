<?php
namespace Fedale\GridviewBundle\Grid;

use Fedale\GridviewBundle\Service\GridviewService;

class GridviewBuilderFactory 
{
    public function __construct(
        private GridviewService $gridviewService
    ) {}

    public function createGridviewBuilder(): GridviewBuilderInterface
    {
        // With an IF you can instantiate different type of GridviewBuilder
        // For example if ($this->config) {return new GridviewImplementation } else return new GridviewImplementation2
        // Add:
        // - Listview
        // - Graph view
        // - Map view
        /* * @return GridviewBuilder */
        return new GridviewBuilder($this->gridviewService);
    }
}