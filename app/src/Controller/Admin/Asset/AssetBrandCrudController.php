<?php

namespace App\Controller\Admin\Asset;

use App\Entity\Asset\AssetBrand;
use App\Controller\Admin\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AssetBrandCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AssetBrand::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextField::new('slug')
                ->onlyWhenUpdating()
            ,
            BooleanField::new('active'),
        ];
    }

   
}
