<?php
namespace Fedale\GridviewBundle\Grid;

use Fedale\GridviewBundle\Service\GridviewService;

class GridviewBuilderFactory
{
    public function __construct(
        private GridviewService $gridviewService,
        private GridviewConfigRegistry $configRegistry,
    ) {}

    public function createGridviewBuilder(): GridviewBuilder
    {
        return new GridviewBuilder($this->gridviewService, $this->configRegistry);
    }
}
