<?php

namespace App\Controller\Admin\Customer;

use App\Entity\Customer\CustomerLocationPlace;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CustomerLocationPlaceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CustomerLocationPlace::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            BooleanField::new('active'),
        ];
    }
}
