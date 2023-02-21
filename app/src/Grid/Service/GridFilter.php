<?php
namespace App\Grid\Service;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormBuilderInterface;
        
class GridFilter
{
    private FormBuilderInterface $builder;
    
    public function __construct(private FormFactoryInterface $formFactory) {
        $this->builder = $formFactory->createBuilder();
    }

    public function add(string $name, $class, array $options) {
        $this->builder->add($name, $class, $options);
    }
} 