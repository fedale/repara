<?php

namespace App\Controller\Admin\Asset;

use App\Entity\Asset\AssetCategory;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AssetCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AssetCategory::class;
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
