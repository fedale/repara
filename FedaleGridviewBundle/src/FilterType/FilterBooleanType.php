<?php 
namespace Fedale\GridviewBundle\FilterType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class FilterBooleanType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'choices' => [
                'label.true' => true,
                'label.false' => false,
            ],
         //   'expanded' => true,
            'translation_domain' => 'GridviewBundle',
            'label_attr' => ['class' => 'radio-inline'],
        ]);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }
}