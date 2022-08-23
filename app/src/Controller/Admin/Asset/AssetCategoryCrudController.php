<?php

namespace App\Controller\Admin\Asset;

use App\Entity\Asset\AssetCategory;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AssetCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AssetCategory::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextField::new('slug')
                ->onlyWhenUpdating()
            ,
            IntegerField::new('lft'),
            IntegerField::new('rgt'),
            //AssociationField::new('parent'),
            // CollectionField::new('children'),
            IntegerField::new('root'),
            //IntegerField::new('lvl'),
            BooleanField::new('active')
        ];
    }
}
