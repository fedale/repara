<?php

namespace App\Controller\Admin\Customer;

use App\Entity\Customer\Customer;
use App\Type\CustomerProfileType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class CustomerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Customer::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('username')
            ->setFormTypeOption('attr.class', 'form-control-lg')
        ;
        yield TextField::new('code')
            ->setFormTypeOption('attr.class', 'form-control-lg')
        ;
        yield TextField::new('email')
            ->setFormTypeOption('attr.class', 'form-control-lg')
        ;
        yield TextField::new('profile.firstname')
            ->setFormType(CustomerProfileType::class)
            // ->setLabel(false)
            ->setFormTypeOption('attr.class', 'form-control-lg')
        ;
        yield TextField::new('profile.lastname')
            ->setFormType(CustomerProfileType::class)
            ->setLabel('Pofile lastname')
            ->setFormTypeOption('attr.class', 'form-control-lg')
        ;
        yield TextField::new('plainPassword')
            ->hideOnIndex()
            ->setFormType(PasswordType::class)
            ->onlyWhenCreating()
            ->setFormTypeOption('validation_groups', 'registration')
            ->setFormTypeOption('attr.class', 'form-control-lg')
        ;
        yield AssociationField::new('type')
            ->renderAsNativeWidget()
            ->setColumns('col-md-6 col-xxl-5')
            ->setFormTypeOption('attr.class', 'form-control-lg')
        ;
        yield DateField::new('createdAt')
            ->onlyOnIndex()
            ->setFormTypeOption('attr.class', 'form-control-lg')
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('username')
            ->add('code')
            ->add('email')
            ->add('createdAt')
        ;
    }
    
}
