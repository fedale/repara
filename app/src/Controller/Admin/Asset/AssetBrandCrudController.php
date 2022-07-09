<?php

namespace App\Controller\Admin\Asset;

use App\Entity\Asset\AssetBrand;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AssetBrandCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AssetBrand::class;
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
