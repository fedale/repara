<?php

namespace App\Controller\Admin\User;

use App\Entity\User\UserGroup;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserGroupCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserGroup::class;
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
