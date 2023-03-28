<?php 
namespace Fedale\GridviewBundle\FilterType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class FilterTextType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        
        $resolver->setDefaults([
            'choices' => [
                'Standard Shipping' => 'standard',
                'Expedited Shipping' => 'expedited',
                'Priority Shipping' => 'priority',
            ],
        ]);
    }

    public function getParent(): string
    {
        return TextType::class;
    }
}