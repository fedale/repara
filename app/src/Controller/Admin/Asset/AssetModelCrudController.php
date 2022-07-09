<?php

namespace App\Controller\Admin\Asset;

use App\Entity\Asset\AssetModel;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AssetModelCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AssetModel::class;
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
