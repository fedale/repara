<?php

namespace App\Controller\Admin\User;

use App\Entity\User\UserType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use App\Controller\Admin\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserType::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextField::new('slug')
                ->onlyWhenUpdating()
            ,
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('name')
        ;
    }
}
