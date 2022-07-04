<?php

namespace App\Controller\Admin\Customer;

use App\Entity\Customer\CustomerLocation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CustomerLocationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CustomerLocation::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('customer'),
            TextField::new('name'),
            TextField::new('address'),
            TextField::new('zipcode'),
            TextField::new('city'),
        ];
    }
    
}
