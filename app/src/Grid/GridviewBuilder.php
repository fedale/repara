<?php
namespace App\Grid;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;

class GridviewBuilder implements GridviewBuilderInterface 
{
    private Environment $twig;
    private Gridview $gridview;
    private EntityManagerInterface $entityManager;

    public function __construct(
        private RequestStack $requestStack,
        Environment $twig,
        EntityManagerInterface $entityManager
    )
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->twig = $twig;
        $this->entityManager = $entityManager;
        $this->reset();
    }

    public function reset()
    {
        $this->gridview = new Gridview($this->twig, $this->entityManager);
    }

    public function setColumns($columns) 
    {
        $this->gridview->setColumns($columns);

        return $this;
    }

    public function setData($data)
    {
        $this->gridview->setData($data);

        return $this;
    }

    public function renderHeader()
    {
        return $this;
    }

    public function renderGridview(): Gridview
    {
        return $this->gridview;
    }
}