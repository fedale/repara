<?php
namespace Fedale\GridviewBundle\Grid;

use Fedale\GridviewBundle\DataProvider\DataProviderInterface;
use Fedale\GridviewBundle\Service\SearchModelInterface;
use Fedale\GridviewBundle\Service\GridviewService;
use Twig\Environment;

class GridviewBuilder implements GridviewBuilderInterface 
{
    private SearchModelInterface $searchModel;

    private Gridview $gridview;

    public function __construct(private GridviewService $gridviewService)
    {
        $this->reset();
    }

    public function reset()
    {
        dump($this->gridviewService);
        $this->gridview = new Gridview($this->gridviewService);
    }

    public function setColumns(array $columns)
    {
        $this->gridview->setColumns($columns);

        return $this;
    }

    public function setSearchModel(SearchModelInterface $searchModel)
    {
        $this->gridview->setSearchModel($searchModel);

        return $this;
    }

    /*
    public function setDataProvider(DataProviderInterface $dataProvider)
    {
        $this->gridview->setDataProvider($dataProvider);

        return $this;
    }*/

    public function setDataProvider(array $dataProviderOptions)
    {
        $this->gridview->setDataProviderOptions($dataProviderOptions);

        return $this;
    }
    
    
    public function setSearchModelType($searchModelType, $data = null, $options = [])
    {
        $this->gridview->setSearchModelType($searchModelType, $data, $options);
        
        return $this;
    }
    
    public function setAttributes(array $attributes) 
    {
        $this->gridview->setAttributes($attributes);
        
        return $this;
    }

    public function renderGridview(): Gridview
    {
        return $this->gridview;
    }
}