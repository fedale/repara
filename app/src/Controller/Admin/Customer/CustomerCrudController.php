<?php

namespace App\Controller\Admin\Customer;

use App\Entity\Customer\Customer;
use App\Type\CustomerProfileType;
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
        yield TextField::new('username');
        yield TextField::new('code');
        yield TextField::new('email');
        yield TextField::new('profile')
            ->setFormType(CustomerProfileType::class)
            ->setLabel(false)
        ;
        yield TextField::new('plainPassword')
            ->hideOnIndex()
            ->setFormType(PasswordType::class)
            ->onlyWhenCreating()
            ->setFormTypeOption('validation_groups', 'registration')
        ;
        yield AssociationField::new('type')
            ->renderAsNativeWidget()
        ;
        yield DateField::new('createdAt')
            ->onlyOnIndex()
        ;
    }
    
}
