<?php

namespace App\Form\User;

use App\Entity\User\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class User1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code')
            ->add('username')
            ->add('email')
            ->add('password')
            ->add('confirmedAt')
            ->add('unconfirmedEmail')
            ->add('blockedAt')
            ->add('registrationIp')
            ->add('active')
            ->add('deletedAt')
            ->add('lastLoginAt')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('roles')
            ->add('profile')
            ->add('type')
            ->add('groups')
            ->add('projectTasks')
            ->add('assignedCustomers')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
