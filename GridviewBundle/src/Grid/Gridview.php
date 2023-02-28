<?php 
namespace Fedale\GridviewBundle\Grid;

use Fedale\GridviewBundle\DataProvider\DataProviderInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Fedale\GridviewBundle\Service\FilterModel;
use Fedale\GridviewBundle\Column\ColumnInterface;
use Fedale\GridviewBundle\Service\FilterModelInterface;

class Gridview {

    private ArrayCollection $columns;
    private ArrayCollection $filters;
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
     * @ var \Fedale\GridviewBundle\Service\FilterModel|null the model that keeps the user-entered filter data. When this property is set,
     * the grid view will enable column-based filtering. Each data column by default will display a text field
     * at the top that users can fill in to filter the data.
     *
     * Note that in order to show an input field for filtering, a column must have its [[DataColumn::attribute]]
     * property set and the attribute should be active in the current scenario of $filterModel or have
     * [[DataColumn::filter]] set as the HTML code for the input field.
     *
     * When this property is not set (null) the filtering feature is disabled.
     */
    public FilterModel $filterModel;
    

    public function __construct(private Environment $twig)
    {
        $this->columns = new ArrayCollection();
    }

    public function getTwig()
    {
        return $this->twig;
    }

    public function getColumns() 
    {
        return $this->columns;
    }

    /*
    public function setColumns(ArrayCollection $columns) 
    {    
        $this->columns = $columns;
    }*/

    public function addColumn(ColumnInterface $column)
    {
        $this->columns->add($column);
    }

    public function getFilterModel()
    {
        return $this->filterModel;
    }

    public function setFilterModel(FilterModelInterface $filterModel) 
    {    
        $this->filterModel = $filterModel;
    }

    public function getDataProvider()
    {
        return $this->dataProvider;
    }

    public function setDataProvider($dataProvider) 
    {    
        $this->dataProvider = $dataProvider;
    }

    public function guessColumns()
    {
        return ['column1' => 'value1'];
    }

    public function setColumns(array $columns)
    {
        // To implement
        if (empty($this->columns)) {
            $this->guessColumns();
        }

        foreach ($columns as $key => $column) {
            
            $column = $this->initColumn($column, $key);

            
            if ($column->isVisible()) {

                $column->setGridview($this);
                if ($column->filter) {
                    continue;
                    $this->filterModel->addFilter('email', TextType::class, []);
                }
                $this->addColumn($column);
            }
        }

        return $this;
    }
    
    /**
     * @var array|string $columnData data coming from controller/service containing data to create a ColumnInterface object
     * @var string $key the 0-based key used to identify column when attribute is not available
     */
    private function initColumn(array|string $columnData, string $key): ColumnInterface
    {
        // If $columnData is a string create a DataColumn which is the default column data type.
        if (is_string($columnData)) {
            $column = $this->createDataColumnFromString($columnData);
        }  else if (is_array($columnData)) {
            $type = isset($columnData['type']) ? $columnData['type'] : 'data';
            $attribute = isset($columnData['attribute']) ? $columnData['attribute'] : 'column_' . $key;
            $value = isset($columnData['value']) ? $columnData['value'] : null;
            $class = "Fedale\\GridviewBundle\\Column\\" . ucfirst($type) . 'Column';

            if (class_exists($class)) { 
                switch ($type) {
                    case 'data':
                        $column = new $class($this, $attribute, null, $columnData['label'] ?? $attribute, []);
                        $column->value = $value;
                    break;
                    default:
                        $column = new $class($this, null, $columnData['label'] ?? $attribute, []);

                    break;
                }
                
                unset($columnData['attribute']);
                unset($columnData['value']);
                unset($columnData['type']);
            } else {
                throw new \Exception(sprintf('Class %s does not exists', $class));
            }
            
            foreach ($columnData as $key => $value) {
                $methodName = 'set' . ucfirst($key);
                if (!method_exists($column, $methodName)) {
                    throw new \Exception('Column has no attribute ' . $key);
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
        
        $column =  new \Fedale\GridviewBundle\Column\DataColumn(
            $this, 
            $matches[1],
            isset($matches[3]) ? $matches[3] : null, 
            isset($matches[5]) ? $matches[5] : $matches[1]
        );
        return $column;
    }

    public function renderGrid(string $view, array $parameters = []): Response
    {
        dump($view);
        $parameters['columns'] = $this->columns;
        $parameters['models'] = $this->dataProvider->getData();
        
        $content = $this->twig->render($view, $parameters);

        $response = new Response();
        $response->setContent($content);

        return $response;
    }
}