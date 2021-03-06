<?php

namespace App\Controller\Admin\User;

use App\Entity\User\UserRole;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserRoleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserRole::class;
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
