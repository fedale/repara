<?php

namespace App\Type;

use APY\DataGridBundle\Grid\Type\GridType;
use APY\DataGridBundle\Grid\GridBuilder;
use Symfony\Component\OptionsResolver\OptionsResolver;
use APY\DataGridBundle\Grid\Source\Entity;
use App\Entity\Customer\Customer;

class CustomerGridType extends GridType
{
    private $entity;

    public function __construct(Entity $entity)
    {
        $this->entity = $entity;    
    }

    public function buildGrid(GridBuilder $builder, array $options = [])
    {
        parent::buildGrid($builder, $options);

        $builder
            ->add('id', 'number', [
                'title'   => '#',
                'primary' => 'true',
            ])
            ->add('name', 'text')
            ->add('created_at', 'datetime', [
                'field' => 'createdAt',
            ])
            ->add('status', 'text');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'source'       => new Entity(Customer::class),
            'persistence'  => true,
            'route'        => 'product_list',
            'filterable'   => false,
            'sortable'     => false,
            'max_per_page' => 20,
        ]);
    }

    public function getName()
    {
        return 'customer_grid';
    }
}