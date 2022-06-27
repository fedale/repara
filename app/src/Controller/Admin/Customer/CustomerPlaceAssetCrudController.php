<?php

namespace App\Controller\Admin\Customer;

use App\Entity\Customer\CustomerPlaceAsset;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CustomerPlaceAssetCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CustomerPlaceAsset::class;
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
