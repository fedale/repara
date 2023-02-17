<?php 
namespace App\Grid;

use App\Entity\Customer\Customer;
use App\Grid\Column\ColumnInterface;
use App\Grid\DataProvider\DataProviderInterface;
use App\Grid\Source\SourceInterface;
use APY\DataGridBundle\Grid\Columns;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class Gridview {

    private $twig;
    private $columns;
    private DataProviderInterface $dataProvider;
    /**
     * @var string the HTML display when the content of a cell is empty.
     * This property is used to render cells that have no defined content,
     * e.g. empty footer or filter cells.
     *
     * Note that this is not used by the [[DataColumn]] if a data item is `null`. In that case
     * the [[\yii\i18n\Formatter::nullDisplay|nullDisplay]] property of the [[formatter]] will
     * be used to indicate an empty data value.
     */
    public $emptyCell = '&nbsp;';
    /**
     * Gridview options
     */
    private $options = [];
    /**
     * @var \App\Service\GridFilter|null the model that keeps the user-entered filter data. When this property is set,
     * the grid view will enable column-based filtering. Each data column by default will display a text field
     * at the top that users can fill in to filter the data.
     *
     * Note that in order to show an input field for filtering, a column must have its [[DataColumn::attribute]]
     * property set and the attribute should be active in the current scenario of $filterModel or have
     * [[DataColumn::filter]] set as the HTML code for the input field.
     *
     * When this property is not set (null) the filtering feature is disabled.
     */
    public \App\Service\GridFilter|null $filterService;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function getTwig()
    {
        return $this->twig;
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

    public function getDataProvider()
    {
        return $this->dataProvider;
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