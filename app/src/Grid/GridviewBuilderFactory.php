<?php
namespace App\Grid;

use App\Grid\Service\GridFilter;
use App\Service\ProxyFilter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;

class GridviewBuilderFactory 
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private RequestStack $requestStack,
        private Environment $twig,
        private GridFilter $gridFilter
    ) {}

    public function createGridviewBuilder(): GridviewBuilderInterface
    {
        // With an IF you can instantiate different type of GridviewBuilder
        // For example if ($this->config) {return new GridviewImplementation } else return new GridviewImplementation2
        return new GridviewBuilder($this->requestStack, $this->twig, $this->entityManager, $this->gridFilter);
    }
}