<?php

namespace App\Form\Customer;

use App\Entity\Customer\Customer;
use App\Form\Model\CustomerCreateModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerRegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code')
            ->add('username')
            ->add('email', EmailType::class, )
            ->add('firstname')
            ->add('lastname')
            ->add('password', PasswordType::class)
            ->add('type')
//            ->add('groups')
            //->add('roles')
  //          ->add('users')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CustomerCreateModel::class,
        ]);
    }
}
