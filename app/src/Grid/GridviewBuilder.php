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

            if ($column->isVisible()) {
                $column->setGridview($this->gridview);
                $this->addColumn($column);
            }
            // $this->addColumn($column);
        }

        return $this;
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

    private function initColumn(array|string $columnData): ColumnInterface
    {
        // If $columnData is a string create a DataColumn which is the default column data type.
        if (is_string($columnData)) {
            $column = $this->createDataColumn($columnData);
        }  else if (is_array($columnData)) {
            $type = isset($columnData['type']) ? $columnData['type'] : 'data'; //ucfirst($columnData['type']) : 'Data';
            $attribute = isset($columndData['attribute']) ? $columnData['attribute'] : '#';
            $class = "App\\Grid\\Column\\" . ucfirst($type) . 'Column';
dump($attribute);
            if (class_exists($class)) { 
                
                $column = new $class($this->gridview, $attribute, 'text', $columnData['label'] ?? $attribute);
                dump($column);

                unset($columnData['attribute']);
                unset($columnData['value']);
                unset($columnData['type']);
            } else {
                throw new \Exception();
            }
            foreach ($columnData as $key => $value) {
                $methodName = 'set' . ucfirst($key);
                if (!method_exists($column, $methodName)) {
                    throw new Exception('Column has no attribute ' . $key);
                }

                $column->$methodName($value);
            }
        }

        // $column->setContent('seContent from Gridview Builder');

        return $column;
    }

    /**
     * Creates a [[DataColumn]] object based on a string in the format of "attribute:format:label".
     * @param string $text the column specification string
     * @return DataColumn the column instance
     * @throws InvalidConfigException if the column specification is invalid
     */
    private function createDataColumn($text) 
    {
        if (!preg_match('/^([^:]+)(:(\w*))?(:(.*))?$/', $text, $matches)) {
            // throw new InvalidConfigException('The column must be specified in the format of "attribute", "attribute:format" or "attribute:format:label"');
            throw new \Exception('The column must be specified in the format of "attribute", "attribute:format" or "attribute:format:label"');
        }

        return new DataColumn(
            $this->gridview, 
            $matches[1], 
            isset($matches[3]) ? $matches[3] : 'text', 
            isset($matches[5]) ? $matches[5] : $matches[1]
        );
    }

   

    public function setDataProvider(DataProviderInterface $dataProvider)
    {
        $this->gridview->setDataProvider($dataProvider);

        return $this;
    }


    public function renderGridview(): Gridview
    {
        // dd($this->gridview);
        return $this->gridview;
    }
}