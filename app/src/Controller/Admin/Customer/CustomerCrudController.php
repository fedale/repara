<?php

namespace App\Controller\Admin\Customer;

use App\Entity\Customer\Customer;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
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
        // yield TextField::new('profile.firstname');
        // yield TextField::new('profile.lastname');
        yield TextField::new('password')
            ->hideOnIndex()
            ->setFormType(PasswordType::class)
            ->onlyWhenCreating()
        ;
        yield AssociationField::new('type')
            ->renderAsNativeWidget()
        ;
        yield DateField::new('createdAt')
            ->onlyOnIndex()
        ;
    }
    
}
