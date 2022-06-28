<?php

namespace App\Controller\Admin\User;

use App\Entity\Employee\Employee;
use App\Entity\User\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    /*
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(['code', 'firstname', 'lastname'])
            ->setDefaultSort(['lastname' => 'ASC'])
        ;
    }

*/
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('code'),
            TextField::new('fullname'),
            TextField::new('profile.email', 'Email')
                ->setSortable(true)
            ,
            TextField::new('profile.status', 'Status')
                ->setSortable(true)
                ,
            ChoiceField::new('profile.type', 'Type')
                ->setChoices([
                    'Electrician' => 'E',
                    'Maintainer' => 'M',
                    'Turner' => 'T',
                ])
                ->setSortable(true)
                ,
            ChoiceField::new('profile.gender', 'Gender')
                ->setChoices([
                    'Male' => 'M',
                    'Female' => 'F'
                ])
                ->setSortable(true)
                ,
            AssociationField::new('groups')
                ->setHelp('Write a message here!')
        ];
    }
}
