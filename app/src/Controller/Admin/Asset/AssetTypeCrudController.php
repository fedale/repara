<?php

namespace App\Controller\Admin\Asset;

use App\Entity\Asset\AssetType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AssetTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AssetType::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextField::new('slug')
                ->onlyWhenUpdating()
            ,
            BooleanField::new('active'),
            // CollectionField::new('models')
        ];
    }
}
