<?php

namespace App\Controller\Admin\Customer;

use App\Entity\Customer\CustomerLocationPlace;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CustomerLocationPlaceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CustomerLocationPlace::class;
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
