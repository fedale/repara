<?php

namespace App\Controller\Admin\User;

use App\EasyAdmin\AssociationCheckboxField;
use App\Admin\Filter\UserProfileFilter;
use App\EasyAdmin\CustomerField;
use App\Entity\Employee\Employee;
use App\Entity\User\User;
use App\Entity\User\UserGroup;
use App\Entity\User\UserRole;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use App\Type\UserProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
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
        yield AssociationField::new('type')
            ->renderAsNativeWidget()
        ;
        yield AssociationField::new('groups')
            ->renderAsNativeWidget()
            ->setFormTypeOption('expanded', true)
            ->setTemplatePath('admin/field/collection.twig')
        ;
        yield AssociationField::new('userRoles')
            ->renderAsNativeWidget()
            ->setFormTypeOption('expanded', true)
            ->setTemplatePath('admin/field/collection.twig')
        ;
        yield AssociationCheckboxField::new('assignedCustomers');
        yield DateField::new('createdAt')
            ->onlyOnIndex()
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('username')
            ->add('code')
            ->add('email')
            ->add('active')
            ->add('groups')
            ->add('userRoles')
            ->add(UserProfileFilter::new('profile'))
        ;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $qb = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $qb->addSelect('profile');
        $qb->addSelect('userRoles');
        $qb->addSelect('groups');
        $qb->leftJoin('entity.profile', 'profile');
        $qb->leftJoin('entity.userRoles', 'userRoles');
        $qb->leftJoin('entity.groups', 'groups');

        return $qb;
    }
}
