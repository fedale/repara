<?php

namespace App\Controller\Admin\User;

use App\Entity\Employee\Employee;
use App\Entity\User\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

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
            TextField::new('username'),
            TextField::new('profile.fullname')
                ->onlyOnIndex()
            ,
            /*TextField::new('profile.firstname')
                ->onlyOnForms()
            ,
            TextField::new('profile.lastname')
                ->onlyOnForms()
            ,*/
            EmailField::new('email', 'Email')
                ->setSortable(true)
            ,
            TextField::new('password')
                ->hideOnIndex()
                ->setFormType(PasswordType::class)
                ->onlyWhenCreating(),
            BooleanField::new('active'),
            /*
            ChoiceField::new('profile.gender', 'Gender')
                ->setChoices([
                    'Male' => 'M',
                    'Female' => 'F'
                ])
                ->setSortable(true)
                ,
            */
            // AssociationField::new('groups')
            //     ->setHelp('Write a message here!')
        ];
    }
}
