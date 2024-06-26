<?php 
namespace Fedale\GridviewBundle\Grid;

use Fedale\GridviewBundle\DataProvider\DataProviderInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Fedale\GridviewBundle\Column\ColumnInterface;
use Fedale\GridviewBundle\Service\SearchModelInterface;
use Fedale\GridviewBundle\Service\SearchFormInterface;
use Fedale\GridviewBundle\Service\GridviewService;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormFactoryInterface;

class Gridview implements GridviewInterface
{
    private ArrayCollection $columns;
    
    private DataProviderInterface $dataProvider;
    
    /**
     * @var string Current unique grid id.
     */
    protected $key;
    
    /**
     * @var string
     */
    protected $prefix = 'grid_';

    /**
     * @var int Unique grid id
     */
    protected static $counter = 0;


    /**
     * @var string the HTML display when the content of a cell is empty.
     * This property is used to render cells that have no defined content,
     * e.g. empty footer or filter cells.
     *
     * Note that this is not used by the [[DataColumn]] if a data item is `null`. In that case
     * the [[\yii\i18n\Formatter::nullDisplay|nullDisplay]] property of the [[formatter]] will
     * be used to indicate an empty data value.
     */
    public string $emptyCell = '&nbsp;';

    /**
     * Gridview attributes
     */
    public array $attr = [];
    public array $containerAttr = [];
    public array $headerAttr = [];
    public array $filterAttr = [];
    public array $rowAttr = [];

    /**
     * @var array|Closure the HTML attributes for the table body rows. This can be either an array
     * specifying the common HTML attributes for all body rows, or an anonymous function that
     * returns an array of the HTML attributes. The anonymous function will be called once for every
     * data model returned by [[dataProvider]]. It should have the following signature:
     *
     * ```php
     * function ($model, $key, $index, $grid)
     * ```
     *
     * - `$model`: the current data model being rendered
     * - `$key`: the key value associated with the current data model
     * - `$index`: the zero-based index of the data model in the model array returned by [[dataProvider]]
     * - `$grid`: the GridView object
     *
     */
    public $rowOptions = [];
    
    /**
     * @ var \Fedale\GridviewBundle\Form\SearchModel|null the model that keeps the user-entered filter data. When this property is set,
     * the grid view will enable column-based filtering. Each data column by default will display a text field
     * at the top that users can fill in to filter the data.
     *
     * Note that in order to show an input field for filtering, a column must have its [[DataColumn::attribute]]
     * property set and the attribute should be active in the current scenario of $searchModel or have
     * [[DataColumn::filter]] set as the HTML code for the input field.
     *
     * When this property is not set (null) the filtering feature is disabled.
     */    
    public ?SearchModelInterface $searchModel = null;

    private FormFactoryInterface $formFactory;

    private Environment $twig;

    private SearchFormInterface $searchForm;

    public function __construct(private GridviewService $gridviewService)
    {
        $this->columns = new ArrayCollection();
        $this->twig = $this->gridviewService->getEnvironment();
        $this->searchForm = $this->gridviewService->getSearchForm();
        $this->dataProvider = $this->gridviewService->getDataProvider();
    }

    /**
     * Get grid key. If value was not set yet method generates new id based on
     * static counter so id will be unique for each new grid instance.
     *
     * @return string
     */
    public function getKey()
    {
        if ($this->key === null) {
            $this->key = $this->prefix . static::$counter++;
        }

        return $this->key;
    }

    public function setRowOptions(array $array)
    {
        $this->rowOptions = $array;
    }

    public function getFormFactory()
    {
        return $this->formFactory;
    }

    public function setFormFactory(FormFactory $formFactory)
    {
        $this->formFactory = $formFactory;
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

    public function getDataProvider()
    {
        return $this->dataProvider;
    }

    
    public function setDataProviderOptions(array $dataProviderOptions) 
    {   
        $sort = $dataProviderOptions['sort'] ?? null;
        $pagination = $dataProviderOptions['pagination'] ?? null;

        // $this->dataProvider->setQueryBuilder($dataProviderOptions['models']);
        $this->dataProvider->prepareModels($dataProviderOptions['models']);
        if (!is_null($sort)) {
            $this->dataProvider->getSort()->setAttributes($dataProviderOptions['sort']);
        }
        if (!is_null($pagination)) {
            $this->dataProvider->getPagination()->setAttributes($dataProviderOptions['pagination']);
        }
    }

    public function setDataProvider($dataProvider) 
    {    
        $this->dataProvider = $dataProvider;

        return $this;
    }

    public function getSearchModel(): ?SearchModelInterface
    {
        return $this->searchModel;
    }

    public function setSearchModel(?SearchModelInterface $searchModel) 
    {    
        $this->searchModel = $searchModel;

        return $this;
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
                
                if (isset($this->searchModel)) {
                    if ($column->isFilterable() && isset($column->filter)) {
                        $options = $column->filter['options'] ?? [];
                        $this->searchForm->addFilter($column->getAttribute(), $column->filter['type'], $options);
                    }
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
                    case 'action':
                        $column = new $class($this, $attribute, null, $columnData['label'] ?? $attribute, []);
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

    public function setAttributes(array $attributes): void
    {
        // Do some implementation with row
        $this->rowAttr = $attributes['row'] ?? [];
        $this->containerAttr = $attributes['container'] ?? [];
        $this->headerAttr = $attributes['header'] ?? [];
        $this->filterAttr = $attributes['filter'] ?? [];

        unset($attributes['row']);
        unset($attributes['container']);
        unset($attributes['header']);
        unset($attributes['filter']);
        
        $this->attr = $attributes; //['id'] = 'my-grid-view'; //$options['key'];
    }

    public function renderGrid(string $view, array $parameters = []): Response
    {
        $parameters = [
            'gridview' => $this,
            'columns' => $this->columns,
            'models' => $this->dataProvider->getData(),
            'pagination' => $this->dataProvider->getPagination() //$parameters['pagination']
        ];

        if (isset($this->searchModel)) {
            $this->searchForm->getModelType()->handleRequest($this->gridviewService->getRequest());
            $parameters['form'] = $this->searchForm->getModelType()->createView(); // ?? $this->searchModel->getBuilder()->createView(); //$parameters['form'],
        }

        $content = $this->twig->render($view, $parameters);

        $response = new Response();
        $response->setContent($content);

        return $response;
    }

   
}