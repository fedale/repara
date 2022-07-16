<?php

namespace App\Controller\Admin\User;

use App\Entity\Employee\Employee;
use App\Entity\User\User;
use App\Entity\User\UserGroup;
use App\Entity\User\UserRole;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use App\Type\UserProfileType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserCrudController extends AbstractCrudController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

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
        yield TextField::new('username');
        yield TextField::new('code');
        yield TextField::new('email');
        yield TextField::new('profile')
            ->setFormType(UserProfileType::class)
            ->setLabel(false)
        ;
        yield TextField::new('plainPassword')
            ->hideOnIndex()
            ->setFormType(PasswordType::class)
            ->onlyWhenCreating()
            ->setFormTypeOption('validation_groups', 'registration')
        ;
        yield AssociationField::new('groups')
            ->setFormType(EntityType::class)
            ->renderAsNativeWidget()
            ->setFormTypeOption('expanded', true)
            ->setTemplatePath('admin/field/collection.twig')
        ;
        yield AssociationField::new('userRoles')
            // ->setFormType(EntityType::class)
            ->renderAsNativeWidget()
            ->setFormTypeOption('expanded', true)
            // ->setTemplatePath('admin/field/collection.twig')
        ;
        yield AssociationField::new('type')
            ->renderAsNativeWidget()
        ;
        yield DateField::new('createdAt')
            ->onlyOnIndex()
        ;
    }
}
