<?php

namespace App\Type;

use App\Entity\Customer\CustomerProfile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CustomerProfileType extends AbstractType
{
    public function getName(): string
    {
        return '';
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // $builder->add('customer_profile', ProfileType::class);
        $builder
           ->add('firstname', TextType::class)
           ->add('lastname', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CustomerProfile::class,
            'class' => 'form-control-lg'
        ]);
    }
}
