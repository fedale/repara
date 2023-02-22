<?php
namespace App\Grid\Service;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\Form\Extension\Core\Type\FormType;

class GridFilter
{
    private FormBuilderInterface $builder;
    private Criteria $criteria;

    public function __construct(private FormFactoryInterface $formFactory) {
        $this->builder = $formFactory->createBuilder(FormType::class, [], ['method' => 'GET']);
    }

    public function add(string $name, $class, array $options) {
        dump('Add called!');
        $this->builder->add($name, $class, $options);
    }

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