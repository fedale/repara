<?php

namespace App\Controller\Admin\User;

use App\Entity\User\UserType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserType::class;
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
