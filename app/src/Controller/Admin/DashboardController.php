<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Customer\CustomerCrudController;
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
use EasyCorp\Bundle\EasyAdminBundle\Dto\BatchActionDto;

class DashboardController extends AbstractDashboardController
{
    #[Route(path: '/admin', name: 'admin')]
    public function index() : Response
    {
        // redirect to some CRUD controller
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($routeBuilder->setController(CustomerCrudController::class)->generateUrl());
    }
    
    public function configureCrud(): Crud
    {
        return parent::configureCrud()
            ->showEntityActionsInlined()
        ;
    }
    
    // public function configureAssets(): Assets
    // {
    //     return parent::configureAssets()
    //          ->addWebpackEncoreEntry('app')
    //     ;
    // }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Repara')
            ->generateRelativeUrls()
            ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Project task', '', ProjectTask::class);
        yield MenuItem::linkToCrud('Templates', '', ProjectTaskTemplate::class);
        yield MenuItem::subMenu('Assets', '')
            ->setSubItems([
                MenuItem::linkToCrud('Installed assets', '', ProjectTask::class),
                MenuItem::linkToCrud('Asset management', '', Asset::class),
                MenuItem::linkToCrud('Asset types', '', AssetType::class),
                MenuItem::linkToCrud('Asset brands', '', AssetBrand::class),
                MenuItem::linkToCrud('Asset models', '', AssetModel::class),
            ]);

        yield MenuItem::linkToCrud('Staff', '', User::class);
        yield MenuItem::linkToCrud('Customers', '', Customer::class);
        yield MenuItem::linkToCrud('Permissions', '', UserType::class);
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

            ->addBatchAction(Action::new('active', '')
                ->linkToCrudAction('deactivate')
                ->addCssClass('btn btn-primary')
                ->setIcon('fa fa-user-check')
            )
            // ->addBatchAction(Action::new('delete', 'Delete selected')
            //     ->linkToCrudAction('approveUsers')
            //     ->addCssClass('btn btn-primary')
            //     ->setIcon('fa fa-user-check')
            // )
        ;
    }

    
}
