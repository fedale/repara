<?php

namespace App\Controller\Admin\Asset;

use App\Entity\Asset\Asset;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AssetCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Asset::class;
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
