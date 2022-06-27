<?php

namespace App\Controller\Admin;

use App\Entity\Website\Website;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;    
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;    
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class WebsiteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Website::class;
    }

  
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            IntegerField::new('defaultGroupId'),
            IntegerField::new('sort'),
        ];
    }
  
}
