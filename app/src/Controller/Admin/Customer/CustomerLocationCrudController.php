<?php

namespace App\Controller\Admin\Customer;

use App\Entity\Customer\CustomerLocation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CustomerLocationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CustomerLocation::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
