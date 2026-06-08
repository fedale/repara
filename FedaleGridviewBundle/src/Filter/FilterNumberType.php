<?php

namespace Fedale\GridviewBundle\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterNumberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('from', TextType::class, [
                'required' => false,
                'label'    => false,
                'attr'     => [
                    'type'      => 'number',
                    'inputmode' => 'numeric',
                    'placeholder' => $options['from_placeholder'],
                ],
            ])
            ->add('to', TextType::class, [
                'required' => false,
                'label'    => false,
                'attr'     => [
                    'type'      => 'number',
                    'inputmode' => 'numeric',
                    'placeholder' => $options['to_placeholder'],
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'required'         => false,
            'label'            => false,
            'from_placeholder' => 'Min',
            'to_placeholder'   => 'Max',
            'attr'             => ['class' => 'gv-number-filter'],
        ]);

        $resolver->setAllowedTypes('from_placeholder', 'string');
        $resolver->setAllowedTypes('to_placeholder', 'string');
    }
}
