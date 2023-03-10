<?php
namespace Fedale\GridviewBundle\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\Form\Extension\Core\Type\FormType;

class FilterModel implements FilterModelInterface
{
    private FormBuilderInterface $builder;
    private Criteria $criteria;

    private ArrayCollection $filters;
    /*
    public function __construct(private FormFactoryInterface $formFactory) {
        $this->builder = $formFactory->createBuilder(FormType::class, [], ['method' => 'GET']);
    }*/

    public function __construct()
    {
        $this->filters = new ArrayCollection();
    }

    public function getFilters()
    {
        return $this->filters;
    }

    public function addFilter($filter)
    {
        $this->filters->add($filter);
    }

    /*
    public function add(string $name, $class, array $options) {
        
        $this->builder->add($name, $class, $options);
    }*/

    public function getCriteria(): Criteria|null
    {
        return $this->criteria ?? null;
    }

    public function setCriteria(Criteria $criteria) 
    {
        $this->criteria = $criteria;
    }

    // public function setFilter(string $filter) 
    // {
    //     $this->filter = $filter;
    // }
} 