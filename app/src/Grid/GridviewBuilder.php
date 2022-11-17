<?php
namespace App\Grid;

use App\Grid\Column\ColumnInterface;
use App\Grid\Column\SerialColumn;
use App\Grid\Column\DataColumn;
use App\Grid\DataProvider\DataProviderInterface;
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

    public function guessColumns()
    {
        return ['column1' => 'value1'];
    }

    public function setColumns($columns)
    {
        if (empty($this->columns)) {
            $this->guessColumns();
        }

        foreach ($columns as $column) {
            $column = $this->initColumn($column);
            dump($column);

            if ($column->isVisible()) {
                $column->setGridview($this->gridview);
                $this->addColumn($column);
            }
            // $this->addColumn($column);
        }

        return $this;
    }

    private function initColumn(array|string $columnData): ColumnInterface
    {
        $options = [];

        if (is_string($columnData)) {
            $column = new DataColumn($options); 
        }  else if (is_array($columnData)) {
            $type = isset($columnData['type']) ? ucfirst($columnData['type']) : 'Data';
            unset($columnData['type']);
            unset($columnData['property']);
            unset($columnData['value']);
            
            $class = "App\\Grid\\Column\\$type" . 'Column';
            if (class_exists($class)) { 
                $column = new $class($options); 
            } else {
                throw new \Exception();
            }

            foreach ($columnData as $key => $value) {
                $methodName = 'set' . ucfirst($key);
                if (!method_exists($column, $methodName)) {
                    throw new Exception('Column has no property '.$key);
                }

                $column->$methodName($value);
            }
        }

        return $column;
    }

    public function addColumn(ColumnInterface $column) 
    {
        $this->gridview->addColumn($column);
        return $this;
/*
        if (is_array($column)) {
            $type = $column['type'];
        } else if (is_string($column)) {
            $type = 'data';
        } else {
            throw new \Exception(); // to customize
        }

        $options = [];

        $column = match($type) {
            'serial' => new SerialColumn($options),
            'data' => new DataColumn($options),
            default => throw new \Exception()
        };

        $column->setLabel('Label');
        $column->setContent('foo!');

        $this->gridview->addColumn($column);
        */
        
    }

    public function setDataProvider(DataProviderInterface $dataProvider)
    {
        $this->gridview->setDataProvider($dataProvider);

        return $this;
    }

    public function renderHeader()
    {
        return $this;
    }

    public function renderGridview(): Gridview
    {
        // dd($this->gridview);
        return $this->gridview;
    }
}