<?php

namespace App\Controller\Admin\User;

use App\EasyAdmin\UserField;
use App\Entity\User\UserGroup;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserGroupCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserGroup::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            UserField::new('users'),
        ];
    }
    
}
