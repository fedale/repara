<?php
namespace App\Grid;

use App\Grid\Column\ColumnInterface;
use App\Grid\Column\SerialColumn;
use App\Grid\Column\DataColumn;
use App\Grid\DataProvider\DataProviderInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;

class GridviewBuilder implements GridviewBuilderInterface 
{
    private Gridview $gridview;
    private $request;

    public function __construct(
        private RequestStack $requestStack,
        private Environment $twig,
        private EntityManagerInterface $entityManager,
    )
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->twig = $twig;
        $this->entityManager = $entityManager;
        $this->reset();
    }

    public function reset()
    {
        $this->gridview = new Gridview($this->twig);
    }

    public function guessColumns()
    {
        return ['column1' => 'value1'];
    }

    public function setColumns($columns)
    {
        if (empty($this->gridview->columns)) {
            $this->guessColumns();
        }

        foreach ($columns as $key => $column) {
            $column = $this->initColumn($column);
            
            if ($column->isVisible()) {

                $column->setGridview($this->gridview);
                if ($column->filter) {
                     $this->gridview->gridFilter->add($column->filter['name'], $column->filter['class'], $column->filter['options']);
                }
                $this->addColumn($column);
                
            }
        }

        return $this;
    }

    public function addColumn(ColumnInterface $column) 
    {
        $this->gridview->addColumn($column);
        return $this;    
    }

    private function initColumn(array|string $columnData): ColumnInterface
    {
        // If $columnData is a string create a DataColumn which is the default column data type.
        if (is_string($columnData)) {
            $column = $this->createDataColumnFromString($columnData);
        }  else if (is_array($columnData)) {
            $type = isset($columnData['type']) ? $columnData['type'] : 'data';
            $attribute = isset($columnData['attribute']) ? $columnData['attribute'] : '#';
            $value = isset($columnData['value']) ? $columnData['value'] : null;
            $class = "App\\Grid\\Column\\" . ucfirst($type) . 'Column';

            if (class_exists($class)) { 
                switch ($type) {
                    case 'data':
                        $column = new $class($this->gridview, $attribute, null, $columnData['label'] ?? $attribute, []);
                        $column->value = $value;
                    break;
                    default:
                        $column = new $class($this->gridview, null, $columnData['label'] ?? $attribute, []);
                    break;
                }
                
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
    private function createDataColumnFromString($text) 
    {
        if (!preg_match('/^([^:]+)(:(\w*))?(:(.*))?$/', $text, $matches)) {
            throw new \Exception('The column must be specified in the format of "attirbute", "attribute:filter" or "attribute:filter:label"');
        }
        
        return new DataColumn(
            $this->gridview, 
            $matches[1],
            isset($matches[3]) ? $matches[3] : null, 
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