<?php

namespace App\Controller\Admin\Asset;

use App\Entity\Asset\AssetModel;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AssetModelCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AssetModel::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            AssociationField::new('brand')
                ->renderAsNativeWidget()
            ,
            AssociationField::new('type')
                ->renderAsNativeWidget()
            ,
            BooleanField::new('active'),
        ];
    }
}
