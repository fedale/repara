<?php

namespace App\Controller\Admin\User;

use App\Entity\User\UserRole;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserRoleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserRole::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('name')
            ->add('code')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextField::new('code'),
            TextField::new('slug')
                ->onlyWhenUpdating()
            ,
            AssociationField::new('parents'),
            //AssociationField::new('children')
        ];
    }
}
