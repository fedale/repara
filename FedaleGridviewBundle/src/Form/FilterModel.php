<?php
namespace Fedale\GridviewBundle\Form;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Form;

class FilterModel implements FilterModelInterface
{
    
    private Form $modelType;
    private Criteria $criteria;

    private ArrayCollection $filters;
    
    public function __construct(private FormFactoryInterface $formFactory) {
        $this->filters = new ArrayCollection();
    }

    /*
    public function __construct()
    {
        $this->filters = new ArrayCollection();
    }*/

    public function getFilters()
    {
        return $this->filters;
    }

    public function addFilter($filter)
    {
        $this->modelType->add($filter);
        $this->filters->add($filter);
    }

    public function getCriteria(): Criteria|null
    {
        return $this->criteria ?? null;
    }

    public function setCriteria(Criteria $criteria) 
    {
        $this->criteria = $criteria;
    }

    public function setFormFactory(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function getModelType()
    {
        return $this->modelType;
    }

    public function setModelType($type, $data, $options)
    {
        $this->modelType = $this->formFactory->create($type, $data, $options);
    }
} 