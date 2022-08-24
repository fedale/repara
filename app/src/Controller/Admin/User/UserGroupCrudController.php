<?php

namespace App\Controller\Admin\User;

use App\EasyAdmin\AssociationCheckboxField;
use App\Entity\User\UserGroup;
use App\Repository\User\UserGroupRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Twig\Environment;

class UserGroupCrudController extends AbstractCrudController
{
    private UserGroupRepository $userGroupRepository;

    private $twig;

    public function __construct(EntityManagerInterface $entityManager, Environment $twig)
    {
        $this->userGroupRepository = $entityManager->getRepository(UserGroup::class);
        $this->twig = $twig;
    }


    public static function getEntityFqcn(): string
    {
        return UserGroup::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            AssociationCheckboxField::new('users'),
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('name')
        ;
    }

    public function configureResponseParameters(KeyValueStore $responseParameters): KeyValueStore
    {
        $this->twig->addGlobal('groups', $this->userGroupRepository->findAll());
        
        return $responseParameters;
    }
    
}
