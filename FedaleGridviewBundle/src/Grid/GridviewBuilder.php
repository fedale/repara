<?php
namespace Fedale\GridviewBundle\Grid;

use Fedale\GridviewBundle\DataProvider\DataProviderInterface;
use Fedale\GridviewBundle\Form\FilterModelInterface;
use Fedale\GridviewBundle\Form\FilterModelType;
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

    public function __construct(
        // private RequestStack $requestStack,
        private Environment $twig,
      //  private EntityManagerInterface $entityManager,
    )
    {
        // $this->request = $requestStack->getCurrentRequest();
        // $this->twig = $twig;
        //$this->entityManager = $entityManager;
        $this->reset();
    }

    public function reset()
    {
        $this->gridview = new Gridview($this->twig);
    }

    public function setColumns(array $columns)
    {
        $this->gridview->setColumns($columns);

        return $this;
    }

    public function setDataProvider(DataProviderInterface $dataProvider)
    {
        $this->gridview->setDataProvider($dataProvider);

        return $this;
    }

    public function setFilterModel(FilterModelInterface $filterModel): self
    {
        dump('setFilterModel method');
        $this->filterModel = $filterModel;
        return $this;
    }
    
    public function setFilterModelType($filterModelType, $data = null, $options = [])
    {
        $this->gridview->setFilterModel($this->filterModel);
        $this->gridview->setFilterModelType($filterModelType, $data, $options);
        
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