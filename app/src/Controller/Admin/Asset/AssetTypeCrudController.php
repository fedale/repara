<?php

namespace App\Controller\Admin\Asset;

use App\Entity\Asset\AssetType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AssetTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AssetType::class;
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
