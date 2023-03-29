<?php
namespace Fedale\GridviewBundle\Grid;

use Fedale\GridviewBundle\DataProvider\DataProviderInterface;
use Fedale\GridviewBundle\Form\FilterModelInterface;
use Fedale\GridviewBundle\Form\FilterModelType;
use Fedale\GridviewBundle\Service\GridviewService;
// use Doctrine\Common\Collections\ArrayCollection;
// use Doctrine\ORM\EntityManager;
// use Doctrine\ORM\EntityManagerInterface;
// use Exception;
// use Iterator;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\RequestStack;
// use Traversable;
use Twig\Environment;

class GridviewBuilder implements GridviewBuilderInterface 
{
    private FilterModelInterface $filterModel;
    private Gridview $gridview;
    // private $request;

    public function __construct(private GridviewService $gridviewService)
    {
        $this->reset();
    }

    public function reset()
    {
        $this->gridview = new Gridview($this->gridviewService);
    }

    public function setColumns(array $columns)
    {
        $this->gridview->setColumns($columns);

        return $this;
    }

    public function setSearchModel($model)
    {
        $this->gridview->setSearchModel($model);

        return $this;
    }


    public function setDataProvider(DataProviderInterface $dataProvider)
    {
        $this->gridview->setDataProvider($dataProvider);

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