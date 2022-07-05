<?php

namespace App\Controller\Admin\Customer;

use App\Entity\Customer\CustomerType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CustomerTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CustomerType::class;
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
