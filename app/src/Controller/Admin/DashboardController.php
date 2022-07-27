<?php

namespace App\Controller\Admin;

use App\Entity\Asset\Asset;
use App\Entity\Asset\AssetBrand;
use App\Entity\Asset\AssetCategory;
use App\Entity\Asset\AssetModel;
use App\Entity\Asset\AssetType;
use App\Entity\Customer\Customer;
use App\Entity\Customer\CustomerLocation;
use App\Entity\Customer\CustomerLocationPlace;
use App\Entity\Customer\CustomerType;
use App\Entity\Project\Task\ProjectTask;
use App\Entity\Project\TaskTemplate\ProjectTaskTemplate;
use App\Entity\Project\TaskTemplate\ProjectTaskItemTemplate;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Website\Website;
use App\Entity\User\User;
use App\Entity\User\UserGroup;
use App\Entity\User\UserRole;
use App\Entity\User\UserType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

class DashboardController extends AbstractDashboardController
{
    #[Route(path: '/admin', name: 'admin')]
    public function index() : Response
    {
        // redirect to some CRUD controller
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($routeBuilder->setController(WebsiteCrudController::class)->generateUrl());
    }
    
    public function configureCrud(): Crud
    {
        return parent::configureCrud()
            ->showEntityActionsInlined()
        ;
    }
    
    public function configureAssets(): Assets
    {
        return Assets::new()
        // ->addWebpackEncoreEntry('app')
        ;
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Repara');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Project');
        yield MenuItem::linkToCrud('Project task', 'fas fa-users', ProjectTask::class);
        yield MenuItem::linkToCrud('Project template', 'fas fa-users', ProjectTaskTemplate::class);
        yield MenuItem::linkToCrud('Project template items', 'fas fa-users', ProjectTaskItemTemplate::class);
        yield MenuItem::section('Scan');
        yield MenuItem::section('Templates');
        
        yield MenuItem::section('Staff');
        yield MenuItem::linkToCrud('Users', 'fas fa-list', User::class);
        yield MenuItem::linkToCrud('Groups', 'fas fa-list', UserGroup::class);
        yield MenuItem::linkToCrud('Types', 'fas fa-list', UserType::class);
        yield MenuItem::linkToCrud('Roles', 'fas fa-list', UserRole::class);
        
        yield MenuItem::section('Asset');
        yield MenuItem::linkToCrud('Asset list', 'fas fa-users', Asset::class);
        yield MenuItem::linkToCrud('Asset brands', 'fas fa-users', AssetBrand::class);
        yield MenuItem::linkToCrud('Asset types', 'fas fa-users', AssetType::class);
        yield MenuItem::linkToCrud('Asset categories', 'fas fa-users', AssetCategory::class);
        yield MenuItem::linkToCrud('Asset models', 'fas fa-users', AssetModel::class);
       
        yield MenuItem::section('Customer');
        yield MenuItem::linkToCrud('Customer list', 'fas fa-users', Customer::class);
        yield MenuItem::linkToCrud('Location', 'fas fa-users', CustomerLocation::class);
        yield MenuItem::linkToCrud('Type', 'fas fa-users', CustomerType::class);
        yield MenuItem::linkToCrud('Place', 'fas fa-users', CustomerLocationPlace::class);
        
        yield MenuItem::section('Permission');
    }

    public function configureActions(): Actions
    {
        return Actions::new()
            ->add(Crud::PAGE_INDEX, Action::NEW)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_INDEX, Action::EDIT)
            ->add(Crud::PAGE_INDEX, Action::DELETE)
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setIcon('fa-solid fa-square-plus')->setLabel('Create new %entity_label_singular%');
            })
            ->update(Crud::PAGE_INDEX, Action::DETAIL, function (Action $action) {
                return $action->setIcon('fa-regular fa-eye')->setLabel(false);
            })
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setIcon('fa fa-file-pen')->setLabel(false);
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action->setIcon('fa-solid fa-trash-can')->setLabel(false);
            })
            ->reorder(Crud::PAGE_INDEX, [Action::DETAIL, Action::EDIT, Action::DELETE])

            ->add(Crud::PAGE_NEW, Action::SAVE_AND_RETURN)
            ->add(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
            ->add(Crud::PAGE_NEW, Action::SAVE_AND_CONTINUE)
            ->add(Crud::PAGE_NEW, Action::INDEX)

            ->add(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN)
            ->add(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE)
            ->add(Crud::PAGE_EDIT, Action::DELETE)
            ->add(Crud::PAGE_EDIT, Action::DETAIL)
            ->add(Crud::PAGE_EDIT, Action::INDEX)

            ->setPermissions(
                [
                    Action::NEW => 'ROLE_ADMIN',
                    Action::EDIT => 'ROLE_ADMIN',
                    Action::DELETE => 'ROLE_ADMIN',
                    Action::BATCH_DELETE => 'ROLE_ADMIN',
                ]
            )
        ;
    }
}
