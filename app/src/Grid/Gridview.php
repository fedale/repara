<?php 
namespace App\Grid;

use App\Entity\Customer\Customer;
use App\Grid\Column\ColumnInterface;
use App\Grid\Source\SourceInterface;
use APY\DataGridBundle\Grid\Columns;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class Gridview {

    private $twig;
    private $columns;
    private $dataProvider;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function getColumns() 
    {
        return $this->columns;
    }

    public function setColumns($columns) 
    {    
        $this->columns = $columns;
    }

    public function addColumn(ColumnInterface $column)
    {
        $this->columns[] = $column;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setDataProvider($dataProvider) 
    {    
        $this->dataProvider = $dataProvider;
    }

/*    public function createColumn(string $column) 
    {
        return match (strtolower($column)) {
            'action' => '', //this->createColumnBuilder()
            'boolean' => '',
            'checkbox' => '',
            'data' => '',
            'radio' => '',
            'serial' => ''
            // 'editable', 'enum', 'expand', 'formula', 
        };
    }
  */

    public function renderGrid(string $view, array $parameters = []): Response
    {
        $this->prepareGrid();
        $parameters['columns'] = $this->columns;
        $parameters['models'] = $this->dataProvider->getData();
        
        $content = $this->twig->render($view, $parameters);

        $response = new Response();
        $response->setContent($content);

        return $response;
    }

    public function prepareGrid()
    {
        // Use $data from dataProvider
        $data = $this->dataProvider->getData();
        // Add not sourceable column, i.e. column with fixed value as Serial, Checkbox and so on
        // Get value per column from source, from Column (checkbox for example) or from callback
    }

  /*  public function getFieldsMetadata($class, $group = 'default')
    {
        $result = [];
        foreach ($this->ormMetadata->getFieldNames() as $name) {
            $mapping = $this->ormMetadata->getFieldMapping($name);
            $values = ['title' => $name, 'source' => true];

            if (isset($mapping['fieldName'])) {
                $values['field'] = $mapping['fieldName'];
                $values['id'] = $mapping['fieldName'];
            }

            if (isset($mapping['id']) && $mapping['id'] == 'id') {
                $values['primary'] = true;
            }

            switch ($mapping['type']) {
                case 'string':
                case 'text':
                    $values['type'] = 'text';
                    break;
                case 'integer':
                case 'smallint':
                case 'bigint':
                case 'float':
                case 'decimal':
                    $values['type'] = 'number';
                    break;
                case 'boolean':
                    $values['type'] = 'boolean';
                    break;
                case 'date':
                    $values['type'] = 'date';
                    break;
                case 'datetime':
                    $values['type'] = 'datetime';
                    break;
                case 'time':
                    $values['type'] = 'time';
                    break;
                case 'array':
                case 'object':
                    $values['type'] = 'array';
                    break;
            }

            $result[$name] = $values;
        }

        return $result;
    }
    */
}