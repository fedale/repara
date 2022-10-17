<?php

namespace App\Form\Customer;

use App\Entity\Customer\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code')
            ->add('username')
            ->add('email')
            ->add('password')
            ->add('unconfirmedEmail')
            ->add('registrationIp')
            ->add('active')
            ->add('confirmedAt')
            ->add('lastLoginAt')
            ->add('blockedAt')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('profile')
            ->add('type')
            ->add('groups')
            //->add('roles')
            ->add('users')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
        ]);
    }
}
