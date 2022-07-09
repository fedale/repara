<?php

namespace App\Controller\Admin;

use App\Entity\Asset\Asset;
use App\Entity\Asset\AssetBrand;
use App\Entity\Asset\AssetModel;
use App\Entity\Asset\AssetType;
use App\Entity\Customer\Customer;
use App\Entity\Customer\CustomerLocation;
use App\Entity\Customer\CustomerLocationPlace;
use App\Entity\Customer\CustomerType;
use App\Entity\Project\ProjectTask;
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
        $crud = parent::configureCrud();
        // $crud->overrideTemplates([
        //     'layout' => 'layout.html.twig',
        //     'crud/index' => 'index.html.twig',
        //     'crud/new' => 'new.html.twig',
        //     'crud/edit' => 'edit.html.twig'
        // ]);
        return $crud;
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
            ->setTitle('App');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Project task', 'fas fa-users', ProjectTask::class);
        yield MenuItem::section('Scan');
        yield MenuItem::section('Templates');
        yield MenuItem::section('Asset');
        yield MenuItem::section('Staff');
        yield MenuItem::linkToCrud('User', 'fas fa-list', User::class);
        yield MenuItem::section('Asset');
        yield MenuItem::linkToCrud('Asset list', 'fas fa-users', Asset::class);
        yield MenuItem::linkToCrud('Asset brands', 'fas fa-users', AssetBrand::class);
        yield MenuItem::linkToCrud('Asset types', 'fas fa-users', AssetType::class);
        yield MenuItem::linkToCrud('Asset models', 'fas fa-users', AssetModel::class);
        yield MenuItem::section('Customer');
        yield MenuItem::linkToCrud('Customer list', 'fas fa-users', Customer::class);
        yield MenuItem::linkToCrud('Location', 'fas fa-users', CustomerLocation::class);
        yield MenuItem::linkToCrud('Type', 'fas fa-users', CustomerType::class);
        yield MenuItem::linkToCrud('Place', 'fas fa-users', CustomerLocationPlace::class);
        yield MenuItem::section('Permission');
        // yield MenuItem::linkToCrud('Employees', 'fas fa-users', Employee::class),
        // yield MenuItem::linkToCrud('Employee groups', 'fas fa-users', EmployeeGroup::class),
        // yield MenuItem::linkToCrud('Company', 'fas fa-users', Company::class),

        // yield MenuItem::linkToCrud('Users', 'fas fa-users', User::class),

        // yield MenuItem::linkToCrud('Markings', 'fas fa-user-clock', Marking::class),
        // yield MenuItem::linkToCrud('Commission markings', 'fas fa-business-time', CommissionMarking::class),
        // yield MenuItem::linkToCrud('Message', 'fas fa-envelope', Message::class),
        // yield // MenuItem::linkToCrud('Message recipients', 'fas fa-envelope-open', MessageRecipient::class),
        // yield MenuItem::linkToCrud('Survey', 'fas fa-poll', Survey::class),
        // MenuItem::linkToCrud('Survey answers', 'fas fa-poll-h', SurveyAnswer::class),

        // yield MenuItem::linkToCrud('USER', 'fas fa-list', User::class);
        // yield MenuItem::linkToCrud('PROFILE', 'fas fa-list', User::class);
        // yield MenuItem::linkToCrud('GROUP', 'fas fa-list', User::class);
        // yield MenuItem::linkToCrud('DOCUMENTATION', 'fas fa-list', User::class);
        // yield MenuItem::linkToCrud('ACTIVITY', 'fas fa-list', User::class);
        // yield MenuItem::subMenu('MEGA MENU', 'fa fa-list')->setSubItems([
        //     MenuItem::linkToUrl('Search in Google', 'fab fa-google', 'https://google.com')
        // ]);
    }
}
