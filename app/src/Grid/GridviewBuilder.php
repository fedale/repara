<?php
namespace App\Grid;

use App\Grid\Column\SerialColumn;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
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
        foreach ($columns as $column) {
            $this->addColumn($column);
        }

        return $this;
    }

    public function addColumn($column) 
    {
        if (is_array($column)) {
            $type = $column['type'];
        } else if (is_string($column)) {
            $type = $column;
        } else {
            throw new \Exception(); // to customize
        }

        $options = [];

        $column = match($type) {
            'serial' => new SerialColumn($options),
            default => throw new \Exception()
        };

        $this->columns[] = $column;
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